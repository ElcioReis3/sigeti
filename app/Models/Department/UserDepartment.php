<?php

namespace App\Models\Department;

use App\Core\AbstractModel;
use App\Models\User;

class UserDepartment extends AbstractModel
{
    protected string $table = 'user_departments';
    protected string $primaryKey = 'id';

    public const MORNING = 'manha';
    public const AFTERNOON = 'tarde';
    public const EVENING = 'noite';
    public const FULLDAY = 'integral';
    public const NOT_APPLICABLE = 'não_aplicavel';
    public const SHIFTS = [
        self::MORNING,
        self::AFTERNOON,
        self::EVENING,
        self::FULLDAY,
        self::NOT_APPLICABLE,
    ];

    protected array $fillable = [
        'user_id',
        'department_id',
        'shift',
    ];

    protected array $required = [
        "user_id" => "O usuário é obrigatório",
        "department_id" => "O departamento é obrigatório",
        "shift" => "O turno é obrigatório",
    ];
    protected bool $timestamps = true;
    protected bool $softDelete = true;

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setUserId(int $userId): void
    {

        if ($userId < 1) {
            throw new \InvalidArgumentException("O ID do usuário é inválido.");
        }

        $this->attributes["user_id"] = $userId;
    }

    public function getUserId(): ?string
    {
        return $this->attributes["user_id"];
    }

    public function setDepartmentId(int $departmentId): void
    {

        if ($departmentId < 1) {
            throw new \InvalidArgumentException("O ID departamento é inválido.");
        }

        $this->attributes["department_id"] = $departmentId;
    }

    public function getDepartmentId(): int
    {
        return $this->attributes["department_id"];
    }

    public function setShift(?string $shift): void
    {
        $shift = $shift ?? self::NOT_APPLICABLE;

        if (!in_array($shift, self::SHIFTS)) {
            throw new \InvalidArgumentException("O turno não é válido.");
        };

        $this->attributes["shift"] = $shift;
    }

    public function getShift(): string
    {
        return $this->attributes["shift"];
    }

    public function department(): ?Department
    {
        return Department::find($this->getDepartmentId());
    }

    public function user(): ?User
    {
        return User::find($this->getUserId());
    }

    public function findByDepartmentAndUser(int $department_id, int $user_id): ?self
    {
        return (new static())->where("department_id", "=", $department_id)->where("user_id", "=", $user_id)->first();
    }

    public static function linksByUser(int $userId): ?array
    {
        return (new static())->where("user_id", "=", $userId)->get();
    }

    public static function validateSchoolUserLinks(array $links): ?array
    {
        $errors = [];

        if (empty($links)) {
            return [
                "Vincule o usuário a pelo menos uma departamento."
            ];
        }

        $validDepartments = [];

        foreach ($links as $link) {
            $departmentId = $link["school_id"] ?? 0;

            $existsDepartment = Department::find((int)$departmentId);
            if (!$existsDepartment) {
                unset($link);
            } else {
                $validDepartments[] = $link;
            }
        }

        $links = $validDepartments;

        $shifts = [];

        foreach ($links as $link) {
            if (!empty($link["shift"])) {
                $shifts[] = $link["shift"];
            }
        }


        $shiftCount = array_count_values($shifts);

        foreach ($shiftCount as $shift => $count) {
            if ($count > 1) {
                $value = match ($shift) {
                    self::FULLDAY => "INTEGRAL",
                    self::MORNING => "MANHÃ",
                    self::AFTERNOON => "TARDE",
                    self::EVENING => "NOITE",

                };

                $errors[] = "O turno {$value} não pode ser usado em mais de um departamento.";
            }
        }

        return $errors;
    }

    public static function validateDepartments(array $links): array
    {
        $validLinks = [];

        foreach ($links as $link) {
            $departmentId = $link["department_id"] ?? 0;

            if (Department::find((int)$departmentId)) {
                $validLinks[] = $link;
            }
        }

        return $validLinks;
    }

    public static function validateDepartmentLinks(array $links): array
    {
        if (empty($links)) {
            return ["Vincule o usuário a pelo menos um departamento."];
        }

        $links = self::validateDepartments($links);

        if (empty($links)) {
            return ["Nenhum departamento válido foi informado."];
        }

        return [];
    }
}