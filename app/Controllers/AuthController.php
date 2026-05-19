<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Email;
use App\Core\Message;
use App\Core\Permission;
use App\Core\Session;
use App\Core\SessionTimeoutMiddleware;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
    }

    public function index(): void
    {
        if (Auth::check()) {
            redirect($this->resolveHomeByPermission());
            return;
        }

        echo $this->view->render("auth/auth-login", [
            "title" => "Entrar | " . APP_NAME
        ]);
    }

    public function authenticate(?array $data): void
    {
        $this->validateCsrfToken($data, "/entrar");

        if (empty($data["email"]) || empty($data["password"])) {
            Message::warning("Os campos EMAIL e SENHA são obrigatórios.");
            redirect("/entrar");
            return;
        }

        $user = User::findByEmail($data["email"]);

        if (!$user || !$user->passwordVerify($data["password"])) {
            Message::warning("Credenciais inválidas.");
            redirect("/entrar");
            return;
        }

        if ($user->getStatus() === User::INACTIVE) {
            Message::error("Usuário está INATIVO. Contate o administrador.");
            redirect("/entrar");
            return;
        }

        if ($user->getStatus() === User::REGISTERED) {
            Message::error("Usuário apenas REGISTRADO. Contate o administrador.");
            redirect("/entrar");
            return;
        }

        $session = new Session();
        $session->set("auth", [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "role_id" => $user->getRoleId(),
        ]);
        $session->regenerate();

        SessionTimeoutMiddleware::start();

        $user->setLastLoginAt();
        $user->save();

        $home = $this->resolveHomeByPermission();

        Message::success("Bem-vindo(a), " . $user->getName() . "!");
        redirect($home);
    }

    public function logout(?array $data): void
    {
        $session = new Session();

        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            Message::error("Token de segurança inválido.");
            redirect("/entrar");
            return;
        }

        $session->unset("auth");
        Message::dark("Sua sessão foi encerrada. Até logo!");
        redirect("/entrar");
    }

    public function create(): void
    {
        Message::warning("O cadastro público não está disponível. Contate o administrador.");
        redirect("/entrar");
    }

    public function store(?array $data): void
    {
        redirect("/entrar");
    }

    public function storeSuccess(): void
    {
        redirect("/entrar");
    }

    public function forgotPassword(): void
    {
        echo $this->view->render("auth/auth-forgot-password", [
            "title" => "Redefinir a Senha | " . APP_NAME
        ]);
    }

    public function sendResetLink(?array $data): void
    {
        $this->validateCsrfToken($data, "/redefinir-senha");

        if (empty($data["email"])) {
            Message::warning("O campo EMAIL é obrigatório.");
            redirect("/redefinir-senha");
            return;
        }

        $user = User::findByEmail($data["email"]);

        if (!$user) {
            Message::success("Se o e-mail estiver cadastrado, você receberá o link de redefinição.");
            redirect("/redefinir-senha");
            return;
        }

        $token = $user->setResetToken();
        $user->save();

        $template = file_get_contents(__DIR__ . "/../Views/Email/forgot-password.php");
        $body = str_replace(
            ["{{NOME_USUARIO}}", "{{LINK_RESET}}", "{{EXPIRACAO_HORAS}}", "{{ANO}}"],
            [$user->getName(), url("/resetar-senha/{$token}"), "2", date("Y")],
            $template
        );

        try {
            (new Email())->bootstrap(
                "Redefinir a Senha | " . APP_NAME,
                $body,
                $user->getEmail(),
                $user->getName()
            )->send();

            Message::success("Se o e-mail estiver cadastrado, você receberá o link de redefinição.");
        } catch (\InvalidArgumentException $e) {
            Message::error("Não foi possível enviar o e-mail. Tente novamente mais tarde.");
            redirect("/redefinir-senha");
            return;
        }

        redirect("/redefinir-senha/sucesso");
    }

    public function sendResetLinkSuccess(): void
    {
        echo $this->view->render("auth/auth-forgot-password-success", [
            "title" => "Redefinir a Senha | " . APP_NAME
        ]);
    }

    public function resetPassword(?array $data): void
    {
        $user = User::findByResetToken($data["token"]);

        if (!$user) {
            Message::error("Link inválido ou expirado. Solicite novamente.");
            redirect("/redefinir-senha");
            return;
        }

        $now = new \DateTimeImmutable("now", new \DateTimeZone(APP_TIMEZONE));
        $expiration = new \DateTimeImmutable($user->getResetExpiresAt(), new \DateTimeZone(APP_TIMEZONE));

        if ($now->diff($expiration)->invert === 1) {
            Message::error("Link inválido ou expirado. Solicite novamente.");
            redirect("/redefinir-senha");
            return;
        }

        echo $this->view->render("auth/auth-reset-password", [
            "title" => "Resetar a Senha | " . APP_NAME,
            "token" => $data["token"],
        ]);
    }

    public function updatePassword(?array $data): void
    {
        $this->validateCsrfToken($data, "/resetar-senha");

        if (empty($data["password"]) || empty($data["password_confirm"])) {
            Message::warning("Os campos SENHA e CONFIRMAR SENHA são obrigatórios.");
            redirect("/resetar-senha");
            return;
        }

        if ($data["password"] !== $data["password_confirm"]) {
            Message::warning("As senhas não conferem.");
            redirect("/resetar-senha");
            return;
        }

        $user = User::findByResetToken($data["token"]);

        if (!$user) {
            Message::error("Link inválido ou expirado. Solicite novamente.");
            redirect("/redefinir-senha");
            return;
        }

        $now = new \DateTimeImmutable("now", new \DateTimeZone(APP_TIMEZONE));
        $expiration = new \DateTimeImmutable($user->getResetExpiresAt(), new \DateTimeZone(APP_TIMEZONE));

        if ($now->diff($expiration)->invert === 1) {
            Message::error("Link inválido ou expirado. Solicite novamente.");
            redirect("/redefinir-senha");
            return;
        }

        try {
            $user->fill([
                "password" => $data["password"],
                "reset_token" => null,
                "reset_expires_at" => null,
            ]);
            $user->save();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/resetar-senha");
            return;
        }

        Message::success("Senha alterada com sucesso. Faça login.");
        redirect("/entrar");
    }

    private function resolveHomeByPermission(): string
    {
        if (Auth::hasPermission(Permission::VIEW_USERS)) {
            return "/admin/dashboard";
        }

        if (Auth::hasPermission(Permission::VIEW_TECHNICIAN_DASHBOARD)) {
            return "/tecnico/dashboard";
        }

        if (Auth::hasPermission(Permission::VIEW_REQUESTER_DASHBOARD)) {
            return "/professor/dashboard";
        }

        if (Auth::hasPermission(Permission::VIEW_MANAGER_DASHBOARD)) {
            return "/gestor/dashboard";
        }

        return "/entrar";
    }
}