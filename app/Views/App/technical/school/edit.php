<?= $this->layout('technical/app', [
    "title" => $title ?? "Técnico | Editar Escola - " . APP_NAME,
    "menuActive" => "escolas",
    "submenuActive" => "todos",
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
                    <h3>Editar Escola</h3>
                    <p class="text-subtitle text-muted">Altere as informações da escola</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/escolas') ?>">Escolas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
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
                                <i class="bi bi-pencil-fill me-2"></i>
                                Editar Escola
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/tecnico/escolas/editar/' . $school->getId()) ?>" method="post">

                                <?= csrf_input() ?>

                                <input type="hidden" name="_method" value="PUT">

                                <!-- Nome -->
                                <div class="form-group">
                                    <label for="name" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-building"></i>
                                        </span>
                                        <input type="text" name="name" id="name"
                                               class="form-control"
                                               placeholder="Nome da escola"
                                               value="<?= old('name', htmlspecialchars($school->getName())) ?>"
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
                                               placeholder="Código da escola (8 caracteres)"
                                               value="<?= old('code', htmlspecialchars($school->getCode()))?>"
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
                                               placeholder="Endereço completo da escola"
                                               value="<?= old('address', htmlspecialchars($school->getAddress()))?>"
                                               required>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="form-group mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Atualizar
                                    </button>
                                    <a href="<?= url('/tecnico/escolas') ?>" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left-circle-fill me-1"></i>
                                        Cancelar
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