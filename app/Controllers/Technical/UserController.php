<?php

namespace App\Controllers\Technical;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Models\Category;
use App\Models\School;
use App\Models\SchoolUser;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requireRole(User::TECHNICAL);
    }

    public function index(): void
    {
        $users = User::all();

        echo $this->view->render("technical/user/index", [
            "users" => $users
        ]);

        clear_old();
    }

    public function create(): void
    {
        $schools = School::all();
        echo $this->view->render("technical/user/create",[
            "schools" => $schools
        ]);

        clear_old();

    }

    public function store(?array $data): void
    {
        $this->validateCsrfToken($data, "/tecnico/usuarios/cadastrar");

        $newUser = new User();

        try {

            $newUser->fill([
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"],
                "document"=> $data["document"] ?? null,
                "role" => $data["role"],
                "status" => $data["status"]
            ]);

            $errors = array_merge(
                $newUser->validate($data),
                $newUser->validateBusinessRule()
            );

            // role === professor
            // Validar escolas

            if($data['role'] === User::TEACH){
                $linksErrors = SchoolUser::validateSchoolUserLinks($data['schools']);
                $errors = array_merge($errors, $linksErrors);
            }

            if ($errors) {
                flash_old($data);
                foreach ($errors as $error) {
                    Message::warning($error);
                }

                redirect("/tecnico/usuarios/cadastrar");
            }
            $newUser->save();
            // role === professor
            // sincronizar as escolas com o usuario

            if($newUser->getRole() === User::TEACH){
                $this->syncronizeSchoolUser($newUser->getId(), $data['schools']);
            }



        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/usuarios/cadastrar");
            return;
        }

        Message::success("Usuário cadastrado com sucesso!");
        redirect("/tecnico/usuarios/editar/" . $newUser->getId());
    }

    public function edit(?array $data): void
    {
        $user = User::find($data['id']);

        if(!$user){
            Message::warning("Esse Usuário não existe!");
            redirect("/tecnico/usuarios");
            return;
        }

        $userSchools = $user->schoolUserLinks();
        $schools = School::all();

        echo $this->view->render("technical/user/edit", [
            "user" => $user,
            "userSchools" => $userSchools,
            "schools" => $schools
        ]);

        clear_old();
    }

    public function update(?array $data): void
    {
        $this->validateCsrfToken($data, "/tecnico/usuarios/editar/" . $data["id"]);

        $user = User::find($data['id']);

        try {
            if(!$user){
                Message::error("Esse Usuário não existe!");
                redirect("/tecnico/usuarios");
                return;
            }

            $user->fill([
                "name" => $data["name"],
                "email" => $data["email"],
                "role" => $data["role"],
                "status" => $data["status"]
            ]);

            if(!empty($data["document"])){
                $user->setDocument($data["document"]);
            }

            if(!empty($data["password"])){
                $user->setPassword($data["password"]);
            }

            $errors = array_merge(
                $user->validate($data),
                $user->validateBusinessRule($user->getId())
            );

            if($data['role'] === User::TEACH){
                $linksErrors = SchoolUser::validateSchoolUserLinks($data['schools']);
                $errors = array_merge($errors, $linksErrors);
            }

            if ($errors) {
                flash_old($data);
                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/tecnico/usuarios/editar/" . $user->getId());
            }
            $user->save();
            $this->removeSchoolUserLinks($user->getId());

            // removeAllSchoolLinks
            if($user->getRole() === User::TEACH){
                $this->syncronizeSchoolUser($user->getId(), $data['schools']);
            }


        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/usuarios/editar/" . $user->getId());
            return;
        }

        Message::success("Usuário atualizado com sucesso!");
        redirect("/tecnico/usuarios/editar/" . $user->getId());

    }

    public function syncronizeSchoolUser(int $userId, array $links): void
    {
        $validSchools = [];

        foreach($links as $link){
            $schoolId = $link["school_id"] ?? 0;

            $existsSchool = School::find((int)$schoolId);
            if(!$existsSchool){
                unset($link);
            }else{
                $validSchools[] = $link;
            }
        }

       foreach ($validSchools as $validSchool) {

           $schoolId = $validSchool["school_id"];
           $shift = $validSchool["shift"];

           try {

               $newSchoolUser = new SchoolUser();
               $newSchoolUser->fill([
                   "school_id" => $schoolId,
                   "user_id" => $userId,
                   "shift" => $shift
               ]);

               $newSchoolUser->save();

           }catch (\InvalidArgumentException $invalidArgumentException) {
               throw new \InvalidArgumentException($invalidArgumentException->getMessage());
           }

       }

    }

    private function removeSchoolUserLinks(int $userId): void
    {
        $links = SchoolUser::linksByUser($userId);

        if(!empty($links)){
            foreach($links as $link){
                $link->delete();
            }
        }
    }


    public function destroy(?array $data): void
    {
        try {
            $user = User::find($data['id']);
            $user->delete();
            Message::success("Usuario removido com sucesso!");
            redirect("/tecnico/usuarios");
            return;



        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/tecnico/usuarios");
            return;
        }
    }
}