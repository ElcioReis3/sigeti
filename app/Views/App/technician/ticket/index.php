<?= $this->layout('technician/app', [
        'title' => $title ?? "Técnico | Chamados - " . APP_NAME,
        'menuActive' => 'chamados',
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
                    <h3>Chamados</h3>
                    <p class="text-subtitle text-muted">Lista de todos os chamados cadastrados</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chamados</li>
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
                            <i class="bi bi-ticket-detailed-fill me-2"></i>
                            Todos os Chamados
                        </h5>
                        <a href="<?= url('/tecnico/chamados/cadastrar') ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle-fill me-1"></i>
                            Novo Chamado
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Título</th>
                                    <th>Departamento</th>
                                    <th>Solicitante</th>
                                    <th>Técnico</th>
                                    <th>Prioridade</th>
                                    <th>Status</th>
                                    <th>Aberto em</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($tickets)): ?>
                                    <?php foreach ($tickets as $ticket): ?>
                                        <tr>
                                            <td><?= $ticket->getId() ?></td>
                                            <td>
                                                <i class="bi bi-ticket-detailed-fill text-primary me-1"></i>
                                                <?= htmlspecialchars($ticket->getTitle()) ?>
                                            </td>
                                            <td>
                                                <i class="bi bi-building text-muted me-1"></i>
                                                <?= htmlspecialchars($ticket->department()?->getName() ?? '—') ?>
                                            </td>
                                            <td>
                                                <i class="bi bi-person-fill text-muted me-1"></i>
                                                <?= htmlspecialchars($ticket->openedBy()?->getName() ?? '—') ?>
                                            </td>
                                            <td>
                                                <?php if ($ticket->getAssignedTo()): ?>
                                                    <i class="bi bi-person-badge-fill text-muted me-1"></i>
                                                    <?= htmlspecialchars($ticket->assignedTo()?->getName() ?? '—') ?>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Não atribuído</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php $priority = $ticket->getPriority(); ?>
                                                <?php if ($priority === 'alta'): ?>
                                                    <span class="badge bg-danger">Alta</span>
                                                <?php elseif ($priority === 'media'): ?>
                                                    <span class="badge bg-warning">Média</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Baixa</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php $status = $ticket->getStatus(); ?>
                                                <?php if ($status === 'aberto'): ?>
                                                    <span class="badge bg-warning">Aberto</span>
                                                <?php elseif ($status === 'em_andamento'): ?>
                                                    <span class="badge bg-primary">Em Andamento</span>
                                                <?php elseif ($status === 'aguardando'): ?>
                                                    <span class="badge bg-info">Aguardando</span>
                                                <?php elseif ($status === 'resolvido'): ?>
                                                    <span class="badge bg-success">Resolvido</span>
                                                <?php elseif ($status === 'finalizado'): ?>
                                                    <span class="badge bg-dark">Finalizado</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Arquivado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y H:i', strtotime($ticket->getOpenedAt())) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <a href="<?= url('/tecnico/chamados/editar/' . $ticket->getId()) ?>"
                                                   class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-fill"></i>
                                                    <span class="d-none d-xl-inline ms-1">Editar</span>
                                                </a>
                                                <a href="<?= url('/tecnico/chamados/' . $ticket->getId() . '/comentarios') ?>"
                                                   class="btn btn-sm btn-info">
                                                    <i class="bi bi-chat-dots-fill"></i>
                                                    <span class="d-none d-xl-inline ms-1">Comentar</span>
                                                </a>
                                                <!-- Botão Excluir -->
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalExcluir<?= $ticket->getId() ?>">
                                                    <i class="bi bi-trash-fill"></i>
                                                    <span class="d-none d-xl-inline ms-1">Excluir</span>
                                                </button>
                                                <!-- Modal Excluir -->
                                                <div class="modal fade text-left"
                                                     id="modalExcluir<?= $ticket->getId() ?>"
                                                     tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                         role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger">
                                                                <h5 class="modal-title white">
                                                                    <i class="bi bi-trash-fill me-2"></i>
                                                                    Excluir Chamado
                                                                </h5>
                                                                <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Tem certeza que deseja excluir o chamado
                                                                <strong>#<?= $ticket->getId() ?>
                                                                    — <?= htmlspecialchars($ticket->getTitle()) ?></strong>?
                                                                <br>
                                                                <small class="text-muted">Esta ação não poderá ser
                                                                    desfeita.</small>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-secondary"
                                                                        data-bs-dismiss="modal">
                                                                    <span class="d-none d-sm-block">Cancelar</span>
                                                                </button>
                                                                <form action="<?= url('/tecnico/chamados/excluir/' . $ticket->getId()) ?>"
                                                                      method="POST" class="d-inline">
                                                                    <?= csrf_input() ?>
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button type="submit" class="btn btn-danger ms-1">
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
                                        <td colspan="9" class="text-center text-muted fst-italic py-4">
                                            <i class="bi bi-inbox-fill me-2"></i>
                                            Nenhum chamado cadastrado ainda.
                                            <a href="<?= url('/tecnico/chamados/cadastrar') ?>">Abrir o primeiro</a>
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
                    <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                    por <a href="" target="_blank"><?= APP_DEVELOPER ?></a>
                </p>
            </div>
        </div>
    </footer>
</div>