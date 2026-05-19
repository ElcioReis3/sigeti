<?= $this->layout('admin/app', [
        'title' => $title ?? "Admin | Novo Departamento - " . APP_NAME,
        'menuActive' => 'departamentos',
        'submenuActive' => 'novo',
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
                    <h3>Novo Departamento</h3>
                    <p class="text-subtitle text-muted">Preencha as informações para criar um novo departamento</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/admin/departamentos') ?>">Departamentos</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Novo</li>
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
                                <i class="bi bi-diagram-3-fill me-2"></i>
                                Informações do Departamento
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/departamentos/cadastrar') ?>" method="post">
                                <?= csrf_input() ?>

                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Nome</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                            class="bi bi-diagram-3-fill"></i></span>
                                                <input type="text" name="name" id="name"
                                                       class="form-control"
                                                       value="<?= old('name') ?>"
                                                       placeholder="Ex: TI, Financeiro, Laboratório de Informática"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="code" class="form-label">Código</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                                <input type="text" name="code" id="code"
                                                       class="form-control"
                                                       value="<?= old('code') ?>"
                                                       placeholder="Ex: TI-001"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="form-label">Descrição</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <textarea name="description" id="description"
                                                  class="form-control"
                                                  placeholder="Descreva o departamento"
                                                  rows="3"><?= old('description') ?></textarea>
                                    </div>
                                    <small class="text-muted">Campo opcional.</small>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="form-label">Endereço / Localização</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                        <input type="text" name="address" id="address"
                                               class="form-control"
                                               value="<?= old('address') ?>"
                                               placeholder="Ex: Bloco B, Sala 12 ou Rua das Flores, 100">
                                    </div>
                                    <small class="text-muted">Campo opcional.</small>
                                </div>

                                <div class="form-group mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Salvar Departamento
                                    </button>
                                    <a href="<?= url('/admin/departamentos') ?>" class="btn btn-secondary">
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
                    <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                    por <a href="" target="_blank"><?= APP_DEVELOPER ?></a>
                </p>
            </div>
        </div>
    </footer>
</div>