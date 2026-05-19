<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Auth\UserProfile;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requirePermission(Permission::EDIT_OWN_PROFILE);
    }

    public function index(): void
    {
        $user = User::find(Auth::user()->id);
        $profile = UserProfile::findByUser($user->getId());
        $layout = $this->resolveLayout();

        echo $this->view->render("account/profile", [
            "user" => $user,
            "profile" => $profile,
            "layout" => $layout
        ]);

        clear_old();
    }

    public function update(?array $data): void
    {
        $this->validateCsrfToken($data, "/perfil");

        $user = User::find(Auth::user()->id);

        if (!$user) {
            Message::warning("Usuário não encontrado ou não existe.");
            redirect("/entrar");
            return;
        }

        try {
            if (!empty(strip_tags(trim($data["name"] ?? "")))) {
                $user->fill(["name" => $data["name"]]);
                $user->save();
            }

            $profile = UserProfile::findByUser($user->getId())
                ?? UserProfile::createForUser($user->getId());

            if ($profile instanceof UserProfile) {
                $profile->fill([
                    "phone" => $data["phone"] ?? null,
                    "extension" => $data["extension"] ?? null,
                    "gender" => $data["gender"] ?? null,
                    "birth_date" => $data["birth_date"] ?? null,
                    "job_title" => $data["job_title"] ?? null,
                    "registration" => $data["registration"] ?? null,
                    "specialty" => $data["specialty"] ?? null,
                    "bio" => $data["bio"] ?? null,
                    "city" => $data["city"] ?? null,
                    "state" => $data["state"] ?? null,
                    "country" => $data["country"] ?? null,
                ]);
                $profile->save();
            }

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/perfil");
            return;
        }

        Message::success("Perfil atualizado com sucesso.");
        redirect("/perfil");
    }

    public function security(): void
    {
        Auth::requirePermission(Permission::CHANGE_OWN_PASSWORD);

        $layout = $this->resolveLayout();

        echo $this->view->render("account/security", [
            "layout" => $layout
        ]);
        clear_old();
    }

    public function updatePassword(?array $data): void
    {
        Auth::requirePermission(Permission::CHANGE_OWN_PASSWORD);

        $this->validateCsrfToken($data, "/seguranca");

        $user = User::find(Auth::user()->id);

        if (!$user) {
            Message::warning("Usuário não encontrado ou não existe.");
            redirect("/entrar");
            return;
        }

        $currentPassword = $data["current_password"] ?? "";
        $newPassword = $data["password"] ?? "";
        $confirmPassword = $data["confirm_password"] ?? "";

        if (!$user->passwordVerify($currentPassword)) {
            Message::warning("A senha atual está incorreta.");
            redirect("/seguranca");
            return;
        }

        if ($newPassword !== $confirmPassword) {
            Message::warning("As senhas NOVA SENHA e CONFIRMAR NOVA SENHA não coincidem.");
            redirect("/seguranca");
            return;
        }

        if ($newPassword === $currentPassword) {
            Message::warning("Para atualizar, informe uma senha diferente da atual.");
            redirect("/seguranca");
            return;
        }

        try {
            $user->setPassword($newPassword);
            $user->save();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/seguranca");
            return;
        }

        Auth::logout();
        Message::success("Senha atualizada com sucesso. Por favor, entre novamente.");
        redirect("/entrar");
    }

    private function resolveLayout(): string
    {
        if (Auth::hasPermission(Permission::VIEW_USERS)) {
            return 'admin/app';
        }

        if (Auth::hasPermission(Permission::VIEW_TECHNICIAN_DASHBOARD)) {
            return 'technician/app';
        }

        return 'teacher/app';
    }
}