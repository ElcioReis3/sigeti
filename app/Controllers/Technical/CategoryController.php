<?php

namespace App\Controllers\Technical;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Category;
use App\Models\School;
use App\Models\User;

class CategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_CATEGORIES);
    }

    public function index(): void
    {
        $categories = Category::all();

        echo $this->view->render("technical/category/index", [
            "categories" => $categories
        ]);
    }

    public function create(): void
    {
        Auth::requirePermission(Permission::CREATE_CATEGORY);
        echo $this->view->render("technical/category/create");
    }

    public function store(?array $data): void
    {
        Auth::requirePermission(Permission::CREATE_CATEGORY);
        $this->validateCsrfToken($data, "/tecnico/categorias/cadastrar");

        $newCategory = new Category();

        $errors = $newCategory->validate($data);

        if ($errors) {
            foreach ($errors as $error) {
                Message::warning($error);
            }

            redirect("/tecnico/categorias/cadastrar");
        }

        if ($newCategory->getCategoryByName($data["name"])) {
            Message::warning("Já existe uma categoria com esse nome");
            redirect("/tecnico/categorias/cadastrar");
            return;
        }

        try {
            $newCategory->fill([
                "name" => $data["name"],
                "description" => $data["description"] ?? null
            ]);

            $newCategory->save();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/categorias/cadastrar");
            return;
        }

        Message::success("Categoria cadastrada com sucesso!");
        redirect("/tecnico/categorias/editar/" . $newCategory->getId());
    }

    public function edit(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_CATEGORY);
        $category = Category::find($data['id']);

        if(!$category){
            Message::error("Essa categoria não existe!");
            redirect("/tecnico/categorias");
            return;
        }

        echo $this->view->render("technical/category/edit", [
            "category" => $category
        ]);
    }

    public function update(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_CATEGORY);
        $this->validateCsrfToken($data, "/tecnico/categorias/editar/" . $data["id"]);

        $category = Category::find($data['id']);

        if(!$category){
            Message::error("Essa categoria não existe!");
            redirect("/tecnico/categorias");
            return;
        }

        $errors = $category->validate($data);

        if ($errors) {
            foreach ($errors as $error) {
                Message::warning($error);
            }

            redirect("/tecnico/categorias/editar/" . $category->getId());
        }

        try {
            $category->fill([
                "name" => $data["name"],
                "description" => $data["description"] ?? null
            ]);

            $category->save();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/categorias/editar/" . $category->getId());
            return;
        }

        Message::success("Categoria atualizada com sucesso!");
        redirect("/tecnico/categorias/editar/" . $category->getId());

    }

    public function destroy(?array $data): void
    {
        Auth::requirePermission(Permission::DELETE_CATEGORY);
        try {
            $category = Category::find($data['id']);
            $category->delete();
            Message::success("Categoria removida com sucesso!");
            redirect("/tecnico/categorias");
            return;



        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/categorias");
            return;
        }
    }
}