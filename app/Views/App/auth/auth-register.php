<?= $this->layout("auth/auth-app", [
        "title" => $title ?? "Cadastrar | " . APP_NAME,
]) ?>

<h1 class="auth-title">Criar conta</h1>
<p class="auth-subtitle mb-5">Informe seus dados para criar sua conta.</p>

<?= \App\Core\Message::render() ?>

<form action="<?= url('/cadastrar') ?>" method="post">

    <?= csrf_input() ?>

    <div class="form-group position-relative has-icon-left mb-4">
        <input type="text" id="name" name="name" class="form-control form-control-xl" placeholder="Nome Completo"
               required>
        <div class="form-control-icon">
            <i class="bi bi-person"></i>
        </div>
    </div>
    <div class="form-group position-relative has-icon-left mb-4">
        <input type="text" id="email" name="email" class="form-control form-control-xl" placeholder="Email" required>
        <div class="form-control-icon">
            <i class="bi bi-envelope"></i>
        </div>
    </div>
    <div class="form-group position-relative has-icon-left mb-4">
        <input type="password" name="password" id="password"
               class="form-control form-control-xl"
               placeholder="Senha"
               style="padding-right: 3rem;"
               required>
        <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <div class="form-control-icon"
             id="togglePassword"
             style="left: auto; right: 1rem; cursor: pointer;">
            <i class="bi bi-eye-slash" id="eyeIcon"></i>
        </div>
    </div>
    <div class="form-group position-relative has-icon-left mb-4">
        <input type="password" name="password_confirm" id="passwordConfirm"
               class="form-control form-control-xl"
               placeholder="Confirme a Senha"
               style="padding-right: 3rem;"
               required>
        <div class="form-control-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <div class="form-control-icon"
             id="toggleConfirmPassword"
             style="left: auto; right: 1rem; cursor: pointer;">
            <i class="bi bi-eye-slash" id="eyeIconConfirmPassword"></i>
        </div>
    </div>
    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Cadastrar</button>
</form>
<div class="text-center mt-5 text-lg fs-4">
    <p class='text-gray-600'>Ja tem uma conta? <a href="<?= url('/entrar') ?>" class="font-bold">Entrar.</a></p>
</div>