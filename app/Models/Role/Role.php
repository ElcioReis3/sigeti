<?php

namespace App\Models\Role;

use App\Core\AbstractModel;

class Role extends AbstractModel
{
    protected string $table = "roles";
    protected string $primaryKey = "id";

    protected array $fillable = [
        "name",
        "description",
        "is_protected",
    ];

    protected array $required = [
        "name" => "O campo NOME é obrigatório.",
    ];

    protected bool $timestamps = true;
    protected bool $softDelete = true;

    public function getId(): int
    {
        return $this->attributes["id"];
    }

    public function setName(string $name): void
    {
        $name = trim(strip_tags($name));

        if (strlen($name) < 3) {
            throw new \InvalidArgumentException("O nome do perfil deve ter pelo menos 3 caracteres.");
        }

        if (strlen($name) > 100) {
            throw new \InvalidArgumentException("O nome do perfil deve ter no máximo 100 caracteres.");
        }

        $this->attributes["name"] = $name;
    }

    public function getName(): string
    {
        return $this->attributes["name"];
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

    public function setIsProtected(bool $isProtected): void
    {
        $this->attributes["is_protected"] = $isProtected ? 1 : 0;
    }

    public function isProtected(): bool
    {
        return (bool) ($this->attributes["is_protected"] ?? false);
    }

    public function existsRoleByName(string $name, ?int $ignoreId = null): bool
    {
        $query = (new static())->where("name", "=", $name);

        if ($ignoreId) {
            $query->where("id", "!=", $ignoreId);
        }

        return $query->first() !== null;
    }

    public function existsUsers(): bool
    {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role_id = :role_id AND deleted_at IS NULL";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":role_id", $this->getId(), \PDO::PARAM_INT);
        $statement->execute();

        return (int) $statement->fetch(\PDO::FETCH_ASSOC)["total"] > 0;
    }

    public function withPermissions(): array
    {
        $sql = "SELECT p.id, p.name, p.label, p.group_name
                FROM permissions p
                INNER JOIN role_permissions rp ON rp.permission_id = p.id
                WHERE rp.role_id = :role_id
                ORDER BY p.group_name, p.label";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":role_id", $this->getId(), \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function validateBusinessRule(?int $ignoreId = null): array
    {
        $errors = [];

        if ($this->existsRoleByName($this->getName(), $ignoreId)) {
            $errors[] = "Já existe um perfil com esse nome.";
        }

        return $errors;
    }

    public function totalRoles(): ?int
    {
        return (new static())
            ->count();
    }

    public function recentlyCreatedAndNonDeletedRoles(): ?array
    {
        return (new static())
            ->orderBy("created_at", "DESC")
            ->limit(5)
            ->get();
    }
}