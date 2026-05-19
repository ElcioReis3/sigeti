<?= $this->layout('admin/app', [
        "title" => $title ?? "Administrador | Editar Categoria - " . APP_NAME,
        "menuActive" => "categorias",
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
                    <h3>Editar Categoria</h3>
                    <p class="text-subtitle text-muted">Altere as informações da categoria</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/admin/categorias') ?>">Categorias</a></li>
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
                                Editar Categoria
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/categorias/editar/' . $category->getId()) ?>" method="post">

                                <?= csrf_input() ?>

                                <input type="hidden" name="_method" value="PUT">

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
                                               value="<?= old('name', htmlspecialchars($category->getName())) ?>"
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
                                                  rows="4"
                                                  required><?= old('description', htmlspecialchars($category->getDescription())) ?></textarea>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="form-group mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Atualizar
                                    </button>
                                    <a href="<?= url('/admin/categorias') ?>" class="btn btn-secondary">
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