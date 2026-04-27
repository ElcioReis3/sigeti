<?php

namespace App\Models;

use App\Core\AbstractModel;
use http\Exception\InvalidArgumentException;

class School extends AbstractModel
{
    protected string $table = "schools";

    protected string $primaryKey = 'id';

    protected array $fillable = [
        "name",
        "code",
        "address"
    ];

    protected array $required = [
        "name" => "O campo NOME é obrigatório.",
        "code" => "O campo CÓDIGO é obrigatório.",
        "address" => "O campo ENDEREÇO é obrigatório."
    ];

    protected bool $timestamps = true;

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setName(string $name): void
    {
        $name = trim(strip_tags($name));

        if (strlen($name) < 15) {
            throw new \InvalidArgumentException("O nome da escola deve ter pelo menos 15 caracteres.");
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

        if (strlen($code) !== 8) {
            throw new \InvalidArgumentException("O código da escola deve ter exatamente 8 caracteres.");
        }

        $this->attributes["code"] = $code;
    }

    public function getCode(): ?string
    {
        return $this->attributes["code"];
    }

    public function setAddress(string $address): void
    {
        $address = trim(strip_tags($address));

        if (strlen($address) < 20) {
            throw new \InvalidArgumentException("O endereço da escola deve ter pelo menos 20 caracteres.");
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
            $errors[] = "Já existe uma escola com esse mesmo nome.";
        }

        if ($this->existsByCode($this->getCode(), $ignoreId)) {
            $errors[] = "Já existe uma escola com esse mesmo código.";
        }

        return $errors;
    }
}