<?php

namespace App\Core;

use \DateTimeImmutable;
use \DateTimeZone;
use PDO;

abstract class AbstractModel
{
    protected PDO $connection;

    protected string $table = "";
    protected string $primaryKey = 'id';
    protected array $fillable = [];

    protected array $required = [];

    protected bool $timestamps = true;

    protected bool $softDelete = true;

    protected array $attributes = [];

    protected array $wheres = [];

    protected array $params = [];

    protected ?int $limitValue = null;

    protected ?int $offsetValue = null;

    protected ?string $orderByColumn = null;

    protected string $orderDirection = 'ASC';

    protected bool $exists = false;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function fill(array $data): self
    {
        foreach ($this->fillable as $field) {

            if (!array_key_exists($field, $data)) {
                continue;
            }

            $value = $data[$field];

            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));

            if (method_exists($this, $setter)) {
                $this->$setter($value);
                continue;
            }

            $this->attributes[$field] = $value;
        }

        return $this;
    }

    public function setFillable(array $fillable): self
    {
        $this->fillable = $fillable;
        return $this;
    }

    public function validate(?array $data): array
    {
        $errors = [];

        foreach ($this->required as $field => $message) {

            if ($field === "password" && !empty($data["id"]) && empty($data["password"])) {
                continue;
            }

            if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
                $errors[] = $message;
            }
        }

        return $errors;
    }

    public function save(): bool
    {
        return $this->exists ? $this->performUpdate() : $this->performInsert();
    }

    public function performInsert(): bool
    {
        try{

            if ($this->timestamps) {
                $now = $this->now();

                $this->attributes['created_at'] = $now;
                $this->attributes['updated_at'] = $now;
            }

            $columns = array_keys($this->attributes);

            $placeholders = [];
            foreach ($columns as $column) {
                $placeholders[] = ':' . $column;
            }

            $sql = sprintf(
                "INSERT INTO %s (%s) VALUES (%s)",
                $this->table,
                implode(', ', $columns),
                implode(', ', $placeholders)
            );

            $statement = $this->connection->prepare($sql);

            $success = $statement->execute($this->attributes);

            if ($success) {
                $lastId = $this->connection->lastInsertId();

                if ($lastId && !isset($this->attributes[$this->primaryKey])) {
                    $this->attributes[$this->primaryKey] = (int)$lastId;
                }

                $this->exists = true;
            }

            return $success;

        }catch (\PDOException $PDOException){

            throw new \InvalidArgumentException(
                "Erro ao inserir registro na tabela {$this->table}: " . $PDOException->getMessage(),
                (int)$PDOException->getCode(),
                $PDOException
            );

        }
    }

    public function performUpdate(): bool
    {
        try {

            if ($this->timestamps) {
                $this->attributes['updated_at'] = $this->now();
            }

            $fields = [];

            foreach ($this->attributes as $column => $value) {
                if ($column !== $this->primaryKey) {
                    $fields[] = "{$column} = :{$column}";
                }
            }

            $sql = sprintf(
                "UPDATE %s SET %s WHERE %s = :%s",
                $this->table,
                implode(', ', $fields),
                $this->primaryKey,
                $this->primaryKey
            );

            $statement = $this->connection->prepare($sql);

            return $statement->execute($this->attributes);

        }catch (\PDOException $PDOException){

            throw new \InvalidArgumentException(
                "Erro ao atualizar registro na tabela {$this->table}: " . $PDOException->getMessage(),
                (int)$PDOException->getCode(),
                $PDOException
            );

        }
    }

    public function delete(): bool
    {
        try {

            if (!$this->exists) {
                return false;
            }

            if ($this->softDelete) {
                $sql = sprintf(
                    "UPDATE %s SET deleted_at = :deleted_at WHERE %s = :id",
                    $this->table,
                    $this->primaryKey
                );

                $statement = $this->connection->prepare($sql);

                return $statement->execute([
                    'deleted_at' => $this->now(),
                    'id' => $this->attributes[$this->primaryKey]
                ]);
            }

            $sql = sprintf(
                "DELETE FROM %s WHERE %s = :id",
                $this->table,
                $this->primaryKey
            );

            $statement = $this->connection->prepare($sql);

            return $statement->execute([
                'id' => $this->attributes[$this->primaryKey]
            ]);

        }catch (\PDOException $PDOException){

            throw new \InvalidArgumentException(
                "Erro ao deletar registro na tabela {$this->table}: " . $PDOException->getMessage(),
                (int)$PDOException->getCode(),
                $PDOException
            );

        }
    }

    public static function find(int $id): ?static
    {
        try {

            $instance = new static();

            $sql = sprintf(
                "SELECT * FROM %s WHERE %s = :id",
                $instance->table,
                $instance->primaryKey
            );

            $instance->applySoftDeleteFilter($sql);

            $sql .= " LIMIT 1";

            $statement = $instance->connection->prepare($sql);
            $statement->execute(['id' => $id]);

            $statement->setFetchMode(\PDO::FETCH_ASSOC);

            $data = $statement->fetch();

            return $data ? static::hydrate($data) : null;

        }catch (\PDOException $PDOException){

            throw new \InvalidArgumentException(
                "Erro ao buscar registro por id: " . $PDOException->getMessage(),
                (int)$PDOException->getCode(),
                $PDOException
            );

        }
    }

    public static function all(): array
    {
        try {

            $instance = new static();

            $sql = "SELECT * FROM {$instance->table}";

            $instance->applySoftDeleteFilter($sql);

            $statement = $instance->connection->query($sql);

            $statement->setFetchMode(\PDO::FETCH_ASSOC);

            $models = [];

            while ($row = $statement->fetch()) {
                $models[] = static::hydrate($row);
            }

            return $models;

        }catch (\PDOException $PDOException){

            throw new \InvalidArgumentException(
                "Erro ao buscar todos os registros: " . $PDOException->getMessage(),
                (int)$PDOException->getCode(),
                $PDOException
            );

        }
    }

    public function where(string $column, string $operator, mixed $value): self
    {
        $param = $column . count($this->params);

        $this->wheres[] = "{$column} {$operator} :{$param}";
        $this->params[$param] = $value;

        return $this;
    }

    public function whereIn(string $column, array $values): self
    {
        $placeholders = [];

        foreach ($values as $i => $value) {
            $param = $column . '_in_' . $i;
            $placeholders[] = ':' . $param;
            $this->params[$param] = $value;
        }

        $this->wheres[] = "{$column} IN (" . implode(', ', $placeholders) . ")";

        return $this;
    }

    public function countGroupBy(string $column): array
    {
        try {

            $sql = "SELECT {$column}, COUNT(*) as total FROM {$this->table}";

            if (!empty($this->wheres)) {
                $sql .= " WHERE " . implode(' AND ', $this->wheres);
            }

            $this->applySoftDeleteFilter($sql);

            $sql .= " GROUP BY {$column}";

            $statement = $this->connection->prepare($sql);

            $statement->execute($this->params);

            return $statement->fetchAll(PDO::FETCH_ASSOC);

        }catch (\PDOException $PDOException){

            throw new \InvalidArgumentException(
                "Erro ao agrupar registros por {$column}: " . $PDOException->getMessage(),
                (int)$PDOException->getCode(),
                $PDOException
            );

        }
    }

    public function get(): array
    {
        try {

            $sql = "SELECT * FROM {$this->table}";

            if (!empty($this->wheres)) {
                $sql .= " WHERE " . implode(' AND ', $this->wheres);
            }

            $this->applySoftDeleteFilter($sql);

            if ($this->orderByColumn) {
                $sql .= " ORDER BY {$this->orderByColumn} {$this->orderDirection}";
            }

            if ($this->limitValue !== null) {
                $sql .= " LIMIT {$this->limitValue}";
            }

            if ($this->offsetValue !== null) {
                $sql .= " OFFSET {$this->offsetValue}";
            }

            $statement = $this->connection->prepare($sql);
            $statement->execute($this->params);

            $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $models = [];
            foreach ($rows as $row) {
                $models[] = static::hydrate($row);
            }

            return $models;

        }catch (\PDOException $PDOException){

            throw new \InvalidArgumentException(
                "Erro ao buscar registros: " . $PDOException->getMessage(),
                (int)$PDOException->getCode(),
                $PDOException
            );

        }
    }

    public function first(): ?static
    {
        try {

            $this->limit(1);

            $sql = "SELECT * FROM {$this->table}";

            if (!empty($this->wheres)) {
                $sql .= " WHERE " . implode(' AND ', $this->wheres);
            }

            $this->applySoftDeleteFilter($sql);

            if ($this->orderByColumn) {
                $sql .= " ORDER BY {$this->orderByColumn} {$this->orderDirection}";
            }

            if ($this->limitValue !== null) {
                $sql .= " LIMIT {$this->limitValue}";
            }

            $statement = $this->connection->prepare($sql);
            $statement->execute($this->params);

            $statement->setFetchMode(PDO::FETCH_ASSOC);

            $data = $statement->fetch();

            return $data ? static::hydrate($data) : null;

        }catch (\PDOException $PDOException){

            throw new \InvalidArgumentException(
                "Erro ao buscar primeiro registro: " . $PDOException->getMessage(),
                (int)$PDOException->getCode(),
                $PDOException
            );

        }
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderByColumn = $column;
        $this->orderDirection = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limitValue = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offsetValue = $offset;
        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function count(): int
    {
        try {

            $sql = "SELECT COUNT(*) as total FROM {$this->table}";

            if (!empty($this->wheres)) {
                $sql .= " WHERE " . implode(' AND ', $this->wheres);
            }

            $this->applySoftDeleteFilter($sql);

            $statement = $this->connection->prepare($sql);
            $statement->execute($this->params);

            return (int)$statement->fetchColumn();

        }catch (\PDOException $PDOException){

            throw new \InvalidArgumentException(
                "Erro ao contar registros: " . $PDOException->getMessage(),
                (int)$PDOException->getCode(),
                $PDOException
            );

        }
    }

    protected static function hydrate(array $data): static
    {
        $instance = new static();
        $instance->attributes = $data;
        $instance->exists = true;

        return $instance;
    }

    protected function now(): string
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone(APP_TIMEZONE)))->format('Y-m-d H:i:s');
    }

    protected function applySoftDeleteFilter(string &$sql): void
    {
        if (!$this->softDelete) {
            return;
        }

        if (stripos($sql, 'WHERE') === false) {
            $sql .= " WHERE deleted_at IS NULL";
        } else {
            $sql .= " AND deleted_at IS NULL";
        }
    }
}