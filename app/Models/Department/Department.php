<?php

namespace App\Models\Department;

use App\Core\AbstractModel;
use App\Models\Ticket\Ticket;

class Department extends AbstractModel
{
    protected string $table = "departments";

    protected string $primaryKey = "id";

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

        if (strlen($name) < 3) {
            throw new \InvalidArgumentException("O nome do departamento deve ter pelo menos 3 caracteres.");
        }

        if (strlen($name) > 150) {
            throw new \InvalidArgumentException("O nome do departamento deve ter no máximo 150 caracteres.");
        }

        $this->attributes["name"] = $name;
    }

    public function getName(): ?string
    {
        return $this->attributes["name"] ?? null;
    }

    public function setCode(string $code): void
    {
        $code = trim(strtoupper($code));

        if (strlen($code) < 2) {
            throw new \InvalidArgumentException("O código do departamento deve ter pelo menos 2 caracteres.");
        }

        if (strlen($code) > 20) {
            throw new \InvalidArgumentException("O código do departamento deve ter no máximo 20 caracteres.");
        }

        $this->attributes["code"] = $code;
    }

    public function getCode(): ?string
    {
        return $this->attributes["code"] ?? null;
    }

    public function setDescription(?string $description): void
    {
        if ($description !== null) {
            $description = trim(strip_tags($description));

            if (strlen($description) > 255) {
                throw new \InvalidArgumentException("A descrição deve ter no máximo 255 caracteres.");
            }
        }

        $this->attributes["description"] = $description;
    }

    public function getDescription(): ?string
    {
        return $this->attributes["description"] ?? null;
    }

    public function setAddress(?string $address): void
    {
        if ($address !== null) {
            $address = trim(strip_tags($address));

            if (strlen($address) > 200) {
                throw new \InvalidArgumentException("O endereço deve ter no máximo 200 caracteres.");
            }
        }

        $this->attributes["address"] = $address;
    }

    public function getAddress(): ?string
    {
        return $this->attributes["address"] ?? null;
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
                ->where("department_id", "=", $this->getId())
                ->count() > 0;
    }

    public function validateBusinessRule(?int $ignoreId = null): array
    {
        $errors = [];

        if ($this->existsDepartmentByName($this->getName(), $ignoreId)) {
            $errors[] = "Já existe um departamento com esse nome.";
        }

        if ($this->existsDepartmentByCode($this->getCode(), $ignoreId)) {
            $errors[] = "Já existe um departamento com esse código.";
        }

        return $errors;
    }

    public function totalDepartments(): ?int
    {
        return (new static())
            ->count();
    }
}