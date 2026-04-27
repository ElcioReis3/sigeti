<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Email;
use App\Core\Message;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
    }

    public function index(): void
    {

        if(Auth::check()){
            if(Auth::role() === User::TECHNICAL){
                redirect("/tecnico/dashboard");
                return;
            }   if(Auth::role() === User::TEACH){
                redirect("/professor/dashboard");
                return;
            }

        }

        echo $this->view->render('auth/auth-login', [
            "title" => "Entrar | " . APP_NAME,
        ]);
    }

    public function authenticate(?array $data):void
    {
        $this->validateCsrfToken($data, "/entrar");

        // 1. Campos obrigatórios
       if(empty($data['email']) || empty($data['password'])) {
            Message::warning("Os campos EMAIL  e SENHA são obrigatorios.");
            redirect("/entrar");
            return;
       }

       // 2. Verificar no banco de dados - email e senha
        $user = User::findByEmail($data['email']);

       if(!$user || !$user->passwordVerify($data['password'])) {
           Message::warning("Credenciais inválidas.");
           redirect("/entrar");
           return;
       }

       $session = new Session();
       $session->set("auth", [
           "id"=> $user->getId(),
           "email"=> $user->getEmail(),
           "name"=> $user->getName(),
           "role"=> $user->getRole()
       ]);

       $session->regenerate();
       $user->setLastLoginAt();
       $user->save();

       // 3. Verificar o status do usuário
       if($user->getStatus() === User::INACTIVE) {
           Message::error("Usuário está INATIVO. Por favor contate o administrador.");
           redirect("/entrar");
           return;
       }

       if($user->getRole() === User::TECHNICAL){
           Message::success("Bemm vindo(a)," . $user->getName());
           redirect("/tecnico/dashboard");
           return;
       }

        if($user->getRole() === User::TEACH){
            Message::success("Bemm vindo(a), professor(a) " . $user->getName());
            redirect("/professor/dashboard");
            return;
        }

        $session->destroy();
        Message::error("Perfil de acesso não reconhecido.");
        redirect("/entrar");


    }
    
    
    public function create(): void
    {
        echo $this->view->render('auth/auth-register');
    }
    public function store(?array $data): void
    {
        $this->validateCsrfToken($data, "/cadastrar");
        // 1. Validação dos campos obrigatórios

        $required = [
            "name" => "O campo NOME é obrigatorio.",
            "email"=> "O campo EMAIL é obrigatorio.",
            "password"=> "O campo SENHA é obrigatorio.",
            "password_confirm"=> "O campo CONFIRME SUA SENHA é obrigatorio."
        ];


       $errors = [];

       foreach ($required as $key => $message) {
           if(empty($data[$key])){
               $errors[] = $message;
           }
       }
       if($errors){
           foreach($errors as $error){
                Message::warning($error);
           }
           redirect("/cadastrar");
           return;
       }

       // 2. Verificar se o e-mail ja existe

        if(User::findByEmail($data["email"])){
            Message::warning("Este e-mail já existe.");
            redirect("/cadastrar");
            return;
        }

        // 3. Verificar se a senha é igual a senha confirmação

        if($data["password"] !== $data["password_confirm"]){
            Message::warning("As senhas devem ser correspondentes.");
            redirect("/cadastrar");
            return;
        }

        $data['role'] = User::TEACH;
        $data['status'] = User::REGISTERED;

        try{

            $newUser = new User();
            $newUser->fill($data);
            $newUser->save();


        }catch (\InvalidArgumentException $exception){
            Message::warning($exception->getMessage());
            redirect("/cadastrar");
            return;
        }
        Message::success("Usuário cadastrado com sucesso!. Faça login para acessar o sistema.");
        redirect("/cadastrar/sucesso");
        return;
    }

    public function logout(?array $data):void
    {
        $session = new Session();

        if(!$data || !csrf_verify($data['_csrf'] ?? null)) {
            Message::error("Token de segurança inválido.");

            $authSession = $session->get("auth");

            if($authSession) {
                if($authSession->role === User::TEACH) {
                    redirect("/professor/dashboard");
                    return;
                }
                if($authSession->role === User::TECHNICAL){
                    redirect("/tecnico/dashboard");
                    return;
                }
            }
            redirect("/entrar");
            return;

        }
        $session->unset("auth");
        Message::secondary("Sua sessão foi encerrada com sucesso!");
        redirect("/entrar");

    }

    public function storeSucess():void
    {
        echo $this->view->render('auth/auth-register-success', [
            "title" => "Conta criada com sucesso!" . APP_NAME,
        ]);
    }

    public function forgotPassword(): void
    {
        echo $this->view->render('auth/auth-forgot-password');
    }

    public function sendResetLink(?array $data):void
    {
        $this->validateCsrfToken($data, "/redefinir-senha");

        if(empty($data["email"])){
            Message::warning("O campo EMAIL é obrigatorio.");
            redirect("/redefinir-senha");
            return;
        }

        $user = User::findByEmail($data["email"]);

        if(!$user){
            Message::warning("Se o e-mail estiver cadastrado, você receberá o link de redefinição de senha.");
            redirect("/redefinir-senha");
            return;
        }

        $token =  $user->setResetToken();
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
                "Redefinir a Senhha | ". APP_NAME,
                $body,
                $user->getEmail(),
                $user->getName()
            );


            $email->send();
            Message::success("Se o e-mail estiver cadastrado, você receberá o link de redefinição de senha.");


        }catch (\InvalidArgumentException $exception){
            Message::warning($exception->getMessage());
            redirect("/redefinir-senha");
            return;
        }

        redirect("/redefinir-senha/sucesso");


    }



    public function sendResetLinkSuccess():void
    {
        echo $this->view->render('auth/auth-forgot-password-success', [
            "title" => "Redefir a senha | " . APP_NAME,
        ]);
    }


    public function resetPassword(?array $data):void
    {
        $user = User::findByResetToken($data["token"]);

        $now = new \DateTimeImmutable("now", new \DateTimeZone(APP_TIMEZONE));
        $expiration = new \DateTimeImmutable($user->getResetExpiresAt(), new \DateTimeZone(APP_TIMEZONE));

        if(!$user || $now->diff($expiration)->invert === 1){
            Message::error("Link inválido ou expirado. Solicite Novamente.");
            redirect("/redefinir-senha");
            return;
        }

        echo $this->view->render('auth/auth-reset-password', [
            "title" => "Resetar a Senha | " . APP_NAME,
            "token" => $user->getResetToken(),
        ]);
    }

    public function updatePassword(?array $data):void
    {
       $this->validateCsrfToken($data, "/resetar-senha");

       if(empty($data["password"]) || empty($data["password_confirm"])){
           Message::warning("Os campos de SENHA e CONFIRMAR SENHA são obrigatorios.");
           redirect("/resetar-senha");
           return;
       }

       if($data["password"] !== $data["password_confirm"]){
           Message::warning("As senhas não conferem.");
           redirect("/resetar-senha");
           return;
       }

       $user = User::findByResetToken($data["token"]);

       $now = new \DateTimeImmutable("now", new \DateTimeZone(APP_TIMEZONE));
       $expiration = new \DateTimeImmutable($user->getResetExpiresAt(), new \DateTimeZone(APP_TIMEZONE));

       if(!$user || $now->diff($expiration)->invert === 1){
            Message::error("Link inválido ou expirado. Solicite Novamente.");
            redirect("/redefinir-senha");
            return;
       }

        try {

           $user->fill([
               "password" => $data["password"],
               "reset_token" => null,
               "reset_expires_at" => null
           ]);

           $user->save();

        }catch (\InvalidArgumentException $exception){
           Message::error($exception->getMessage());
           redirect("/resetar-senha");
           return;
        }

       Message::success("Senha alterada com sucesso!. Faça login para acessar o sistema.");
       redirect("/entrar");
       return;
    }


}