<?= $this->layout('admin/app', [
        'title' => $title ?? "Administrador | Categorias - " . APP_NAME,
        'menuActive' => 'categorias',
        'submenuActive' => 'todos',
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
                    <h3>Categorias</h3>
                    <p class="text-subtitle text-muted">Lista de todas as categorias cadastradas</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categorias</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?= \App\Core\Message::render() ?>

        <div class="page-content">
            <section class="section">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-tag-fill me-2"></i>
                            Todas as Categorias
                        </h5>
                        <a href="<?= url('/admin/categorias/cadastrar') ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle-fill me-1"></i>
                            Nova Categoria
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td><?= $category->getId() ?></td>
                                            <td>
                                                <i class="bi bi-tag-fill text-primary me-1"></i>
                                                <?= htmlspecialchars($category->getName()) ?>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($category->getDescription()) ?>
                                            </td>
                                            <td>
                                                <a href="<?= url('/admin/categorias/editar/' . $category->getId()) ?>"
                                                   class="btn btn-sm btn-warning"
                                                   title="Editar">
                                                    <i class="bi bi-pencil-fill"></i>
                                                    <span class="d-none d-xl-inline ms-1">Editar</span>
                                                </a>

                                                <!-- Botão que abre o modal -->
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalExcluir<?= $category->getId() ?>">
                                                    <i class="bi bi-trash-fill"></i>
                                                    <span class="d-none d-xl-inline ms-1">Excluir</span>
                                                </button>

                                                <!-- Modal Excluir -->
                                                <div class="modal fade text-left"
                                                     id="modalExcluir<?= $category->getId() ?>"
                                                     tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                         role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger">
                                                                <h5 class="modal-title white">
                                                                    <i class="bi bi-trash-fill me-2"></i>
                                                                    Excluir Categoria
                                                                </h5>
                                                                <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                Tem certeza que deseja excluir a categoria
                                                                <strong><?= htmlspecialchars($category->getName()) ?></strong>?
                                                                <br>
                                                                <small class="text-muted">Esta ação não poderá ser
                                                                    desfeita.</small>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-secondary"
                                                                        data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Cancelar</span>
                                                                </button>
                                                                <form action="<?= url('/admin/categorias/excluir/' . $category->getId()) ?>"
                                                                      method="POST" class="d-inline">

                                                                    <?= csrf_input() ?>

                                                                    <input type="hidden" name="_method" value="DELETE">

                                                                    <button type="submit" class="btn btn-danger ms-1">
                                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                                        <span class="d-none d-sm-block">Confirmar</span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted fst-italic py-4">
                                            <i class="bi bi-inbox-fill me-2"></i>
                                            Nenhuma categoria cadastrada ainda.
                                            <a href="<?= url('/admin/categorias/cadastrar') ?>">Criar a primeira</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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