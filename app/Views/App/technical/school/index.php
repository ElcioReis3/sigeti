<?= $this->layout('technical/app', [
    'title' => $title ?? "Técnico | Escolas - " . APP_NAME,
    'menuActive' => 'escolas',
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
                    <h3>Escolas</h3>
                    <p class="text-subtitle text-muted">Lista de todas as escolas cadastradas</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Escolas</li>
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
                            <i class="bi bi-building me-2"></i>
                            Todas as Escolas
                        </h5>
                        <a href="<?= url('/tecnico/escolas/cadastrar') ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle-fill me-1"></i>
                            Nova Escola
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Código</th>
                                    <th>Endereço</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($schools)): ?>
                                    <?php foreach ($schools as $school): ?>
                                        <tr>
                                            <td><?= $school->getId() ?></td>
                                            <td>
                                                <i class="bi bi-building text-primary me-1"></i>
                                                <?= htmlspecialchars($school->getName()) ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-light-secondary">
                                                    <?= htmlspecialchars($school->getCode()) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <i class="bi bi-geo-alt-fill text-muted me-1"></i>
                                                <?= htmlspecialchars($school->getAddress()) ?>
                                            </td>
                                            <td>
                                                <a href="<?= url('/tecnico/escolas/editar/' . $school->getId()) ?>"
                                                   class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-fill"></i> Editar
                                                </a>
                                                <!-- Botão que abre o modal -->
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalExcluir<?= $school->getId() ?>">
                                                    <i class="bi bi-trash-fill"></i> Excluir
                                                </button>
                                                <!-- Modal Excluir -->
                                                <div class="modal fade text-left"
                                                     id="modalExcluir<?= $school->getId() ?>"
                                                     tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                         role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger">
                                                                <h5 class="modal-title white">
                                                                    <i class="bi bi-trash-fill me-2"></i>
                                                                    Excluir Escola
                                                                </h5>
                                                                <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Tem certeza que deseja excluir a escola
                                                                <strong><?= htmlspecialchars($school->getName()) ?></strong>?
                                                                <br>
                                                                <small class="text-muted">Esta ação não poderá ser desfeita.</small>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-secondary"
                                                                        data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Cancelar</span>
                                                                </button>
                                                                <form action="<?= url('/tecnico/escolas/excluir/' . $school->getId()) ?>"
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
                                            Nenhuma escola cadastrada ainda.
                                            <a href="<?= url('/tecnico/escolas/cadastrar') ?>">Cadastrar a primeira</a>
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