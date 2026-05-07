<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Email;
use App\Core\Message;
use App\Core\Permission;
use App\Core\Session;
use App\Models\User;
use DateTimeZone;

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

        if (empty($data['email']) || empty($data['password'])) {
            Message::warning("Os campos EMAIL e SENHA são obrigatorios.");
            redirect("/entrar");
            return;
        }

        $user = User::findByEmail($data['email']);

        if (!$user || !$user->passwordVerify($data['password'])) {
            Message::warning("Credenciais inválidas.");
            redirect("/entrar");
            return;
        }

        if ($user->getStatus() === User::INACTIVE) {
            Message::error("Usuário está INATIVO. Contate o administrador.");
            redirect("/entrar");
            return;
        }

        if($user->getStatus() === User::REGISTERED){
            Message::error("Usuário apenas REGISTRADO. Contate o administrador.");
            redirect("/entrar");
            return;
        }

        $session = new Session();

        $session->set("auth", [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "role" => $user->getRole(),
            "role_id" => $user->getRoleId()
        ]);

        $session->regenerate();

        $user->setLastLoginAt();
        $user->save();

        $home = $this->resolveHomeByPermission();

        Message::success("Bem-vindo(a), " . $user->getName() . "!");
        redirect($home);
    }

    public function logout(?array $data): void
    {
        $session = new Session();

        if (!$data || !csrf_verify($data['_csrf'] ?? null)) {
            Message::error("Token de segurança inválido");

            $authSession = $session->get("auth");

            if ($authSession) {

                if ($authSession->role === User::TECHNICAL) {
                    redirect("/tecnico/dashboard");
                    return;
                }

                if ($authSession->role === User::TEACH) {
                    redirect("/professor/dashboard");
                    return;
                }

            }

            redirect("/entrar");
            return;

        }

        $session->unset("auth");
        Message::dark("Sua sessão foi encerrada, mas volte logo!");
        redirect("/entrar");

    }

    public function create(): void
    {
        echo $this->view->render("auth/auth-register", [
            "title" => "Cadastrar | " . APP_NAME
        ]);
    }

    public function store(?array $data): void
    {
        $this->validateCsrfToken($data, "/cadastrar");

        $required = [
            "name" => "O campo NOME é obrigatorio.",
            "email" => "O campo EMAIL é obrigatorio.",
            "password" => "O campo SENHA é obrigatorio.",
            "password_confirm" => "O campo CONFIRMAR SENHA é obrigatorio.",
        ];

        $errors = [];
        foreach ($required as $value => $message) {
            if (empty($data[$value])) {
                $errors[] = $message;
            }
        }

        if ($errors) {
            foreach ($errors as $error) {
                Message::warning($error);
            }
            redirect("/cadastrar");
            return;
        }

        if (User::findByEmail($data['email'])) {
            Message::warning("O e-mail informado já está cadastrado.");
            redirect("/cadastrar");
            return;
        }

        if ($data['password'] !== $data['password_confirm']) {
            Message::warning("As senhas não correspondem.");
            redirect("/cadastrar");
            return;
        }

        $data['role'] = User::TEACH;
        $data['status'] = User::REGISTERED;

        try {

            $newUser = new User();
            $newUser->fill($data);
            $newUser->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/cadastrar");
            return;
        }

        Message::success("Usuário cadastrado com sucesso. Faça Login!");
        redirect("/cadastrar/sucesso");
    }

    public function storeSuccess(): void
    {
        echo $this->view->render("auth/auth-register-success", [
            "title" => "Conta criada | " . APP_NAME
        ]);
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

        if (empty($data['email'])) {
            Message::warning("O campo EMAIL é obrigatório.");
            redirect("/redefinir-senha");
            return;
        }

        $user = User::findByEmail($data['email']);

        if (!$user) {
            Message::success("Se o e-mail estiver cadastrado, você receberá o link de redefinição de senha");
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
            $email = new Email();
            $email->bootstrap(
                "Redefinir a Senha | " . APP_NAME,
                $body,
                $user->getEmail(),
                $user->getName(),
            );

            $email->send();

            Message::success("Se o e-mail estiver cadastrado, você receberá o link de redefinição de senha");

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error("Não foi possível enviar o e-mail. Tente novamente mais tarde!");
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
        $user = User::findByResetToken($data['token']);

        $now = new \DateTimeImmutable("now", new \DateTimeZone(APP_TIMEZONE));
        $expiration = new \DateTimeImmutable($user->getResetExpiresAt(), new DateTimeZone(APP_TIMEZONE));

        if (!$user || $now->diff($expiration)->invert === 1) {
            Message::error("Link inválido ou expirado. Solicite novamente.");
            redirect("/redefinir-senha");
            return;
        }

        echo $this->view->render("auth/auth-reset-password", [
            "title" => "Resetar a Senha | " . APP_NAME,
//            "token" => $user->getResetToken(),
            "token" => $data['token']
        ]);
    }

    public function updatePassword(?array $data): void
    {
        $this->validateCsrfToken($data, "/resetar-senha");

        if (empty($data['password']) || empty($data['password_confirm'])) {
            Message::warning("Os campos SENHA e CONFIRMAR SENHA são obrigatórios.");
            redirect("/resetar-senha");
            return;
        }

        if ($data['password'] !== $data['password_confirm']) {
            Message::warning("As senhas não conferem.");
            redirect("/resetar-senha");
            return;
        }

        $user = User::findByResetToken($data['token']);

        $now = new \DateTimeImmutable("now", new \DateTimeZone(APP_TIMEZONE));
        $expiration = new \DateTimeImmutable($user->getResetExpiresAt(), new DateTimeZone(APP_TIMEZONE));

        if (!$user || $now->diff($expiration)->invert === 1) {
            Message::error("Link inválido ou expirado. Solicite novamente.");
            redirect("/redefinir-senha");
            return;
        }

        try {

            $user->fill([
                "password" => $data['password'],
                "reset_token" => null,
                "reset_expires_at" => null,
            ]);

            $user->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/resetar-senha");
            return;
        }

        Message::success("Senha alterada com sucesso. Faça Login.");
        redirect("/entrar");
    }

    private function resolveHomeByPermission(): string
    {
        if (Auth::hasPermission(Permission::VIEW_USERS)) {
            return "/admin/dashboard";
        }

        if (Auth::hasPermission(Permission::VIEW_TECHNICAL_DASHBOARD)) {
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