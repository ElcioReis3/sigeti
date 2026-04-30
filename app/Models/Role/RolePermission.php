<?php

namespace App\Models\Role;

use App\Core\AbstractModel;

class RolePermission extends AbstractModel
{
    protected string $table = 'role_permissions';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'role_id',
        'permission_id',
    ];

    protected array $required = [
        "role_id" => "Este dado é obrigatório.",
        "permission_id" => "Este dado é obrigatório.",
    ];
    protected bool $timestamps = true;

    protected bool $softDelete = false;

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setRoleId(int $roleId): void
    {
        if ($roleId < 1) {
            throw new \InvalidArgumentException("O perfil é inválido.");
        }
        $this->attributes["role_id"] = $roleId;
    }

    public function getRoleId(): string
    {
        return $this->attributes["role_id"];
    }

    public function setPermissionId(int $permissionId): void
    {
        if ($permissionId < 1) {
            throw new \InvalidArgumentException("A permissão é inválida.");
        }

        $this->attributes["permission_id"] = $permissionId;
    }

    public function getPermissionId(): ?string
    {
        return $this->attributes["permission_id"];
    }


    public function getCreatedAt(): string
    {
        return $this->attributes["created_at"];
    }


    public function role(): ?Role
    {
        return Role::find($this->getRoleId());
    }

    public function permission(): ?Permission
    {
        return Permission::find($this->getPermissionId());
    }

    public static function userHasPermission(int $roleId, string $permission): bool
    {
        $sql = "SELECT COUNT(*) as total
                FROM role_permissions rp
                INNER JOIN permissions p ON p.id = rp.permission_id
                WHERE rp.role_id = :role_id
                  AND p.name = :permission";

        $instance = new static();
        $statement = $instance->connection->prepare($sql);
        $statement->bindValue(":role_id", $roleId, \PDO::PARAM_INT);
        $statement->bindValue(":permission", $permission, \PDO::PARAM_STR);
        $statement->execute();

        return (int)$statement->fetch(\PDO::FETCH_ASSOC)["total"] > 0;
    }

    public static function syncPermissions(int $roleId, array $permissionIds): void
    {
        $instance = new static();

        $sqlDelete = "DELETE FROM role_permissions WHERE role_id = :role_id";
        $statement = $instance->connection->prepare($sqlDelete);
        $statement->bindValue(":role_id", $roleId, \PDO::PARAM_INT);
        $statement->execute();

        if (empty($permissionIds)) {
            return;
        }

        $sqlInsert = "INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
        $statement = $instance->connection->prepare($sqlInsert);

        foreach ($permissionIds as $permissionId) {
            $statement->bindValue(":role_id", $roleId, \PDO::PARAM_INT);
            $statement->bindValue(":permission_id", (int)$permissionId, \PDO::PARAM_INT);
            $statement->execute();
        }
    }

    public static function permissionIdsByRole(int $roleId): array
    {
        $instance = new static();

        $sql = "SELECT permission_id
                FROM role_permissions
                WHERE role_id = :role_id";

        $statement = $instance->connection->prepare($sql);
        $statement->bindValue(":role_id", $roleId, \PDO::PARAM_INT);
        $statement->execute();

        return array_column($statement->fetchAll(\PDO::FETCH_ASSOC), "permission_id");
    }
}