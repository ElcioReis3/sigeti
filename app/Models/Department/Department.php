<?php

namespace App\Models\Department;

use App\Core\AbstractModel;

class Department extends AbstractModel
{
    protected string $table = "departments";

    protected string $primaryKey = 'id';

    protected array $fillable = [
        "name",
        "code",
        "description",
        "address",

    ];

    protected array $required = [
        "name" => "O campo NOME é obrigatório.",
        "code" => "O campo CÓDIGO é obrigatório.",
    ];

    protected bool $timestamps = true;

    protected bool $softDelete = true;

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setName(string $name): void
    {
        $name = trim(strip_tags($name));

        if (strlen($name) < 15) {
            throw new \InvalidArgumentException("O nome do departamento deve ter pelo menos 15 caracteres.");
        }

        if (strlen($name) > 150) {
            throw new \InvalidArgumentException("O nome do departamento deve ter no máximo 150 caracteres.");
        }

        $this->attributes["name"] = $name;
    }

    public function getName(): ?string
    {
        return $this->attributes["name"];
    }

    public function setCode(string $code): void
    {
        $code = trim($code);

        if (strlen($code) < 2) {
            throw new \InvalidArgumentException("O código do departamento deve ter pelo menos 2 caracteres.");
        }

        if (strlen($code) > 20) {
            throw new \InvalidArgumentException("O código do departamento deve ter até 20 caracteres.");
        }

        $this->attributes["code"] = $code;
    }

    public function getCode(): string
    {
        return $this->attributes["code"];
    }


    public function setDescription(string $description): void
    {
        $description = trim(strip_tags($description));

        if (strlen($description) < 15) {
            throw new \InvalidArgumentException("A descrição do departamento deve ter pelo menos 15 caracteres.");
        }

        if (strlen($description) > 250) {
            throw new \InvalidArgumentException("A descrição do departamento deve ter no máximo 150 caracteres.");
        }

        $this->attributes["description"] = $description;
    }

    public function getDescription(): ?string
    {
        return $this->attributes["description"] ?? null;
    }

    public function setAddress(string $address): void
    {
        $address = trim(strip_tags($address));

        if (strlen($address) < 5) {
            throw new \InvalidArgumentException("O endereço do departamento deve ter pelo menos 5 caracteres.");
        }

        if (strlen($address) > 50) {
            throw new \InvalidArgumentException("O endereço do departamento deve ter no máximo 50 caracteres.");
        }

        $this->attributes["address"] = $address;
    }

    public function getAddress(): ?string
    {
        return $this->attributes["address"];
    }

    public function findByCode(string $code): ?self
    {
        return (new static())->where("code", "=", $code)->first();
    }

    public function findByName(string $name): ?self
    {
        return (new static())->where("name", "=", $name)->first();
    }

    public function existsByName(string $name, ?int $ignoreId = null): bool
    {
        $query = (new static())->where("name", "=", $name);

        if ($ignoreId) {
            $query->where("id", "!=", $ignoreId);
        }

        return $query->first() !== null;
    }

    public function existsByCode(string $code, ?int $ignoreId = null): bool
    {
        $query = (new static())->where("code", "=", $code);

        if ($ignoreId) {
            $query->where("id", "!=", $ignoreId);
        }

        return $query->first() !== null;
    }

    public function validateBusinessRule(?int $ignoreId = null): array
    {
        $errors = [];

        if ($this->existsByName($this->getName(), $ignoreId)) {
            $errors[] = "Já existe um departamento com esse mesmo nome.";
        }

        if ($this->existsByCode($this->getCode(), $ignoreId)) {
            $errors[] = "Já existe um departamento com esse mesmo código.";
        }

        return $errors;
    }

    public function existsDepartmentByCode(string $code, ?int $ignoreId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE code = :code AND deleted_at IS NULL";
        $params = ["code" => $code];

        if ($ignoreId) {
            $sql .= " AND id != :ignore_id";
            $params["ignore_id"] = $ignoreId;
        }

        $statement = $this->connection->prepare($sql);
        $statement->execute($params);

        return (int)$statement->fetchColumn() > 0;
    }

    public function existsDepartmentByName(string $name, ?int $ignoreId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE name = :name AND deleted_at IS NULL";
        $params = ["name" => $name];

        if ($ignoreId) {
            $sql .= " AND id != :ignore_id";
            $params["ignore_id"] = $ignoreId;
        }

        $statement = $this->connection->prepare($sql);
        $statement->execute($params);

        return (int)$statement->fetchColumn() > 0;
    }

    public function existsUsers(): bool
    {
        return (new UserDepartment())
                ->where("department_id", "=", $this->getId())
                ->count() > 0;
    }

    public function existsTickets(): bool
    {
        return (new Ticket())
                ->where("school_id", "=", $this->getId())
                ->count() > 0;
    }

    public static function totalDepartments():?int
    {
        $instance = new static();
        $sql = "select count(*) from departments where deleted_at IS NULL";

        $statement = $instance->connection->prepare($sql);
        $statement->execute();

        $totalDepartments = $statement->fetchColumn();

        return $totalDepartments;
    }
}