<?= $this->layout("auth/auth-app", [
        "title" => $title ?? "Esqueci a senha | " . APP_NAME,
]) ?>

<h1 class="auth-title">Esqueceu a senha?</h1>
<p class="auth-subtitle mb-5">Informe seu e-mail para receber o link de recuperação.</p>

<?= \App\Core\Message::render() ?>

<form action="<?= url('/redefinir-senha') ?>" method="post">
    <div class="form-group position-relative has-icon-left mb-4">

        <?= csrf_input() ?>

        <input type="email" name="email" class="form-control form-control-xl" placeholder="Email" required>
        <div class="form-control-icon">
            <i class="bi bi-envelope"></i>
        </div>
    </div>
    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Enviar</button>
</form>
<div class="text-center mt-5 text-lg fs-4">
    <p class='text-gray-600'>Lembrou da sua conta? <a href="<?= url('/entrar') ?>" class="font-bold">Entrar.</a>
    </p>
</div>