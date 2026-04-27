<?= $this->layout("auth/auth-app", [
    "title" => $title ?? "Verifique seu e-mail | " . APP_NAME,
]) ?>

<div class="text-center mb-4">
    <i class="bi bi-envelope-check" style="font-size: 4rem; color: #0d6efd;"></i>
</div>

<h1 class="auth-title text-center">Verifique seu e-mail</h1>

<p class="auth-subtitle mb-5 text-center">
    Enviamos um link para redefinição de senha. Siga as instruções no e-mail para continuar.
</p>

<div class="alert alert-success alert-dismissible fade show text-center">
    <strong>Sucesso:</strong> Se o e-mail estiver cadastrado, você receberá o link de recuperação.
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
</div>

<div class="mb-4 text-center">
    <ul class="text-muted text-start d-inline-block">
        <li>Abra o e-mail de recuperação</li>
        <li>Clique no link enviado</li>
        <li>Defina uma nova senha</li>
    </ul>
</div>

<div class="text-center mt-4">
    <a href="<?= url('/entrar') ?>" class="btn btn-primary btn-lg">
        Ir para login
    </a>
</div>

<div class="text-center mt-3">
    <p class="text-muted">
        Não recebeu o e-mail?<br>
        <small>
            Verifique sua caixa de spam ou
            <a href="<?= url('/redefinir-senha') ?>">tente novamente</a>.
        </small>
    </p>
</div>


