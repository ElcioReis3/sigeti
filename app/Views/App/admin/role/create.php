<?= $this->layout('admin/app', [
        'title' => $title ?? "Admin | Novo Perfil - " . APP_NAME,
        'menuActive' => 'perfis',
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
                    <h3>Novo Perfil</h3>
                    <p class="text-subtitle text-muted">Preencha as informações para criar um novo perfil</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/admin/perfis') ?>">Perfis</a></li>
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
                                <i class="bi bi-shield-fill me-2"></i>
                                Informações do Perfil
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/perfis/cadastrar') ?>" method="post">
                                <?= csrf_input() ?>

                                <div class="form-group">
                                    <label for="name" class="form-label">Nome do perfil</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-shield-fill"></i>
                                        </span>
                                        <input type="text" name="name" id="name"
                                               class="form-control"
                                               placeholder="Ex: Professor, Funcionário, Analista de TI"
                                               value="<?= old('name') ?>"
                                               required>
                                    </div>
                                    <small class="text-muted">O nome é livre — defina conforme a realidade da sua
                                        organização.</small>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="form-label">Descrição</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-card-text"></i>
                                        </span>
                                        <textarea name="description" id="description"
                                                  class="form-control"
                                                  placeholder="Descreva as responsabilidades deste perfil"
                                                  rows="3"><?= old('description') ?></textarea>
                                    </div>
                                    <small class="text-muted">Campo opcional.</small>
                                </div>

                                <div class="form-group mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Salvar Perfil
                                    </button>
                                    <a href="<?= url('/admin/perfis') ?>" class="btn btn-secondary">
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