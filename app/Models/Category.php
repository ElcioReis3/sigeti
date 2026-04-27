<?php

namespace App\Models;

use App\Core\AbstractModel;
use http\Exception\InvalidArgumentException;

class Category extends AbstractModel
{
    protected string $table = "categories";

    protected string $primaryKey = "id";

    protected array $fillable = ["name", "description"];

    protected array $required = [
        "name" => "O campo nome é obrigatorio.",
        "description" => "O campo description é obrigatorio.",
    ];
    protected bool $timestamps = true;

    public function getId():?int
    {
        return $this->attributes["id"];
    }

    public function setName(string $name): void
    {
        $name = trim(strip_tags($name));

        if (strlen($name) < 5) {
            throw new InvalidArgumentException("O nome da categoria deve ter pelo menos 5 caracteres.");
        }

        $this->attributes["name"] = $name;


    }

    public function getName(): ?string
    {
        return $this->attributes["name"];
    }

    public function setDescription(string $description): void
    {
        $description = trim(strip_tags($description));

        if (strlen($description) < 15) {
            throw new InvalidArgumentException("A descrição deve conter no mínimo 15 caracteres.");
        };

        $this->attributes["description"] = $description;


    }

    public function getDescription(): ?string
    {
        return $this->attributes["description"];
    }

    public function getCategoryByName(string $name): ?self
    {
        return $this->where("name", "=", $name)->first();
    }
}