<?= $this->layout("auth/auth-app", [
        "title" => $title ?? "Atualizar a senha | " . APP_NAME,
]) ?>

<h1 class="auth-title">Atualizar a senha</h1>
<p class="auth-subtitle mb-5">Informe uma nova senha para seu usuário</p>

<?= \App\Core\Message::render() ?>

<form action="<?= url('/resetar-senha') ?>" method="post">
    <div class="form-group position-relative has-icon-left mb-4">

        <?= csrf_input() ?>

        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

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
    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Resetar</button>
</form>