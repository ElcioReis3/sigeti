<?= $this->layout("auth/auth-app", [
        "title" => $title ?? "Conta criada | " . APP_NAME,
]) ?>

<div class="text-center mb-4">
    <i class="bi bi-check-circle" style="font-size: 4rem; color: #198754;"></i>
</div>

<h1 class="auth-title text-center">Conta criada com sucesso</h1>

<p class="auth-subtitle mb-5 text-center">
    Sua conta foi criada com sucesso. Agora você já pode acessar o sistema.
</p>

<div class="text-center mt-3">
    <p class="text-muted">
        Já tem tudo pronto! Faça login para continuar.
    </p>
</div>

<div class="text-center mt-4">
    <a href="<?= url('/entrar') ?>" class="btn btn-primary btn-lg">
        Entrar
    </a>
</div>