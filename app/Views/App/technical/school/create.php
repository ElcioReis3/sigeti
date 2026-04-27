<?= $this->layout('technical/app', [
        "title" => $title ?? "Técnico | Nova Escola - " . APP_NAME,
        "menuActive" => "escolas",
        "submenuActive" => "nova",
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
                    <h3>Nova Escola</h3>
                    <p class="text-subtitle text-muted">Preencha as informações para cadastrar uma nova escola</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/escolas') ?>">Escolas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nova</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?= \App\Core\Message::render() ?>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="bi bi-building me-2"></i>
                                Informações da Escola
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/tecnico/escolas/cadastrar') ?>" method="post">

                                <?= csrf_input() ?>

                                <!-- Nome -->
                                <div class="form-group">
                                    <label for="name" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-building"></i>
                                        </span>
                                        <input type="text" name="name" id="name"
                                               class="form-control"
                                               value="<?= old('name') ?>"
                                               placeholder="Nome da escola"
                                               required>
                                    </div>
                                </div>

                                <!-- Código -->
                                <div class="form-group">
                                    <label for="code" class="form-label">Código</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-upc"></i>
                                        </span>
                                        <input type="text" name="code" id="code"
                                               class="form-control"
                                               value="<?= old('code') ?>"
                                               placeholder="Código da escola (8 caracteres)"
                                               maxlength="8"
                                               required>
                                    </div>
                                    <small class="text-muted">O código deve ter exatamente 8 caracteres.</small>
                                </div>

                                <!-- Endereço -->
                                <div class="form-group">
                                    <label for="address" class="form-label">Endereço</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </span>
                                        <input type="text" name="address" id="address"
                                               class="form-control"
                                               value="<?= old('address') ?>"
                                               placeholder="Endereço completo da escola"
                                               required>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="form-group mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Salvar Escola
                                    </button>
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
                    <span class="text-danger">
                        <i class="bi bi-heart-fill icon-mid"></i>
                    </span>
                    por
                    <a href="" target="_blank"><?= APP_DEVELOPER ?></a>
                </p>
            </div>
        </div>
    </footer>
</div>