<?= $this->layout('admin/app', [
        "title" => $title ?? "Administrador | Nova Categoria - " . APP_NAME,
        "menuActive" => "categorias",
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
                    <h3>Nova Categoria</h3>
                    <p class="text-subtitle text-muted">Preencha as informações para criar uma nova categoria</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/admin/categorias') ?>">Categorias</a></li>
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
                                <i class="bi bi-tag-fill me-2"></i>
                                Informações da Categoria
                            </h4>
                        </div>
                        <div class="card-body">

                            <form action="<?= url('/admin/categorias/cadastrar') ?>" method="post">

                                <?= csrf_input() ?>

                                <!-- Nome -->
                                <div class="form-group">
                                    <label for="name" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-tag-fill"></i>
                                        </span>
                                        <input type="text" name="name" id="name"
                                               class="form-control"
                                               placeholder="Nome da categoria"
                                               value="<?= old('name') ?>"
                                               required>
                                    </div>
                                </div>

                                <!-- Descrição -->
                                <div class="form-group">
                                    <label for="description" class="form-label">Descrição</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-card-text"></i>
                                        </span>
                                        <textarea name="description" id="description"
                                                  class="form-control"
                                                  placeholder="Descreva a categoria"
                                                  rows="4"><?= old('description') ?></textarea>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="form-group mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Salvar Categoria
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