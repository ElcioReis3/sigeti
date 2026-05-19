<?php

namespace App\Models\Department;

use App\Core\AbstractModel;
use App\Models\User;

class UserDepartment extends AbstractModel
{
    protected string $table = "user_departments";

    protected string $primaryKey = "id";

    protected array $fillable = [
        "user_id",
        "department_id"
    ];

    protected array $required = [
        "user_id" => "O campo USUÁRIO é obrigatório.",
        "department_id" => "O campo DEPARTAMENTO é obrigatório."
    ];

    protected bool $timestamps = true;

    protected bool $softDelete = true;

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setUserId(int $userId): void
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException("O usuário informado é inválido.");
        }

        $this->attributes["user_id"] = $userId;
    }

    public function getUserId(): int
    {
        return $this->attributes["user_id"];
    }

    public function setDepartmentId(int $departmentId): void
    {
        if ($departmentId <= 0) {
            throw new \InvalidArgumentException("O departamento informado é inválido.");
        }

        $this->attributes["department_id"] = $departmentId;
    }

    public function getDepartmentId(): int
    {
        return $this->attributes["department_id"];
    }

    public function department(): ?Department
    {
        return Department::find($this->getDepartmentId());
    }

    public function user(): ?User
    {
        return User::find($this->getUserId());
    }

    public static function linksByUser(int $userId): array
    {
        return (new static())
            ->where("user_id", "=", $userId)
            ->get();
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