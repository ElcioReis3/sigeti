<?= $this->layout($layout, [
        'title' => $title ?? "Segurança - " . APP_NAME,
        'menuActive' => 'conta',
        'submenuActive' => 'seguranca',
]) ?>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Segurança</h3>
                    <p class="text-subtitle text-muted">Altere sua senha de acesso</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/perfil') ?>">Perfil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Segurança</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?= \App\Core\Message::render() ?>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="bi bi-lock-fill me-2"></i>
                                Alterar Senha
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/seguranca') ?>" method="post">
                                <?= csrf_input() ?>

                                <div class="form-group">
                                    <label for="current_password" class="form-label">Senha Atual</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" name="current_password" id="current_password"
                                               class="form-control"
                                               placeholder="Digite sua senha atual"
                                               required>
                                        <button type="button" class="btn btn-outline-secondary" id="toggleCurrent">
                                            <i class="bi bi-eye-fill" id="eyeCurrent"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" name="password" id="password"
                                               class="form-control"
                                               placeholder="Mínimo 8 caracteres"
                                               required>
                                        <button type="button" class="btn btn-outline-secondary" id="toggleNew">
                                            <i class="bi bi-eye-fill" id="eyeNew"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password" class="form-label">Confirmar Nova Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                               class="form-control"
                                               placeholder="Repita a nova senha"
                                               required>
                                        <button type="button" class="btn btn-outline-secondary" id="toggleConfirm">
                                            <i class="bi bi-eye-fill" id="eyeConfirm"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Alterar Senha
                                    </button>
                                    <a href="<?= url('/perfil') ?>" class="btn btn-secondary ms-2">
                                        <i class="bi bi-arrow-left-circle-fill me-1"></i>
                                        Voltar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p><?= date('Y') . " - " . APP_NAME ?></p>
            </div>
            <div class="float-end">
                <p>
                    Desenvolvido com
                    <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                    por <a href="" target="_blank"><?= APP_DEVELOPER ?></a>
                </p>
            </div>
        </div>
    </footer>
</div>

<script>
    function toggleVisibility(buttonId, inputId, iconId) {
        const button = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        button.addEventListener('click', function () {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            }
        });
    }

    toggleVisibility('toggleCurrent', 'current_password', 'eyeCurrent');
    toggleVisibility('toggleNew', 'password', 'eyeNew');
    toggleVisibility('toggleConfirm', 'confirm_password', 'eyeConfirm');
</script>