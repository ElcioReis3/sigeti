<?= $this->layout("auth/auth-app", [
        "title" => $title ?? "Entrar | " . APP_NAME,
]) ?>

<h1 class="auth-title">Entrar</h1>
<p class="auth-subtitle mb-5">Informe seus dados para entrar no SIGETI.</p>

<?= \App\Core\Message::render() ?>

<form action="<?= url('/entrar') ?>" method="post">

    <?= csrf_input() ?>

    <div class="form-group position-relative has-icon-left mb-4">
        <input type="email" name="email" class="form-control form-control-xl" placeholder="Email" required>
        <div class="form-control-icon">
            <i class="bi bi-person"></i>
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
    <div class="form-check form-check-lg d-flex align-items-end">
        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
        <label class="form-check-label text-gray-600" for="flexCheckDefault">
            Me mantenha conectado
        </label>
    </div>

    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Entrar</button>
</form>
<div class="text-center mt-5 text-lg fs-4">
    <p class="text-gray-600">Ainda não tem conta?<a href="<?= url('/cadastrar') ?>" class="font-bold"> Criar agora.</a>
    </p>
    <p><a class="font-bold" href="<?= url('/redefinir-senha') ?>">Esqueceu a senha?</a></p>
</div>