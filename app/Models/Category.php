<?php

namespace App\Models;

use App\Core\AbstractModel;
use App\Models\Ticket\Ticket;

class Category extends AbstractModel
{
    protected string $table = "categories";

    protected string $primaryKey = 'id';

    protected array $fillable = [
        "name",
        "description",
    ];

    protected array $required = [
        "name" => "O campo NOME é obrigatório.",
        "description" => "O campo DESCRIÇÃO é obrigatório.",
    ];

    protected bool $timestamps = true;

    //Novo
    protected bool $softDelete = true;

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setName(string $name): void
    {
        $name = trim(strip_tags($name));

        if (strlen($name) < 5) {
            throw new \InvalidArgumentException("A categoria deve ter pelo menos 5 caracteres.");
        }

        //Novo
        if (strlen($name) > 100) {
            throw new \InvalidArgumentException("O nome deve ter no máximo 100 caracteres.");
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

        if (strlen($description) < 20) {
            throw new \InvalidArgumentException("A descrição da categoria deve ter pelo menos 20 caracteres.");
        }

        //Novo
        if (strlen($description) > 255) {
            throw new \InvalidArgumentException("A descrição deve ter no máximo 255 caracteres.");
        }

        $this->attributes["description"] = $description;
    }

    public function getDescription(): ?string
    {
        return $this->attributes["description"];
    }

    //Atualizado
    public function findCategoryByName(string $name): ?self
    {
        return $this->where("name", "=", $name)->first();
    }

    //Novo
    public function existsCategoryByName(string $name, ?int $ignoreId = null): bool
    {
        $query = (new static())->where("name", "=", $name);

        if ($ignoreId) {
            $query->where("id", "!=", $ignoreId);
        }

        return $query->first() !== null;
    }

    //Novo
    public function existsTickets(): bool
    {
        return (new Ticket())->where("category_id", "=", $this->getId())->count() > 0;
    }

    //Novo
    public function validateBusinessRule(?int $ignoreId = null): array
    {
        $errors = [];

        if ($this->existsCategoryByName($this->getName(), $ignoreId)) {
            $errors[] = "Já existe uma categoria com esse mesmo nome.";
        }

        return $errors;
    }

}