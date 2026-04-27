<?= $this->layout('technical/app', [
        "title" => $title ?? "Técnico | Comentários - " . APP_NAME,
        "menuActive" => "chamados",
        "submenuActive" => "todos",
]) ?>

<?php
$loggedUserId = \App\Core\Auth::user()->id;
?>

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
                    <h3>Comentários</h3>
                    <p class="text-subtitle text-muted">
                        Chamado <strong>#<?= $ticket->getId() ?></strong> —
                        <?= htmlspecialchars($ticket->getTitle()) ?>
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/chamados') ?>">Chamados</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Comentários</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?= \App\Core\Message::render() ?>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">

                    <!-- Resumo do Chamado -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-ticket-detailed-fill me-2"></i>
                                Resumo do Chamado
                            </h5>
                            <a href="<?= url('/tecnico/chamados/editar/' . $ticket->getId()) ?>"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-fill me-1"></i> Editar
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <small class="text-muted d-block">Título</small>
                                    <strong><?= htmlspecialchars($ticket->getTitle()) ?></strong>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <small class="text-muted d-block">Escola</small>
                                    <span>
                                        <i class="bi bi-building text-primary me-1"></i>
                                        <?= htmlspecialchars($ticket->school()?->getName() ?? '—') ?>
                                    </span>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <small class="text-muted d-block">Professor</small>
                                    <span>
                                        <i class="bi bi-person-fill text-primary me-1"></i>
                                        <?= htmlspecialchars($ticket->openedBy()?->getName() ?? '—') ?>
                                    </span>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <small class="text-muted d-block">Técnico Responsável</small>
                                    <span>
                                        <i class="bi bi-person-badge-fill text-primary me-1"></i>
                                        <?= htmlspecialchars($ticket->assignedTo()?->getName() ?? 'Não atribuído') ?>
                                    </span>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <small class="text-muted d-block">Prioridade</small>
                                    <?php $priority = $ticket->getPriority(); ?>
                                    <?php if ($priority === \App\Models\Ticket::LOW): ?>
                                        <span class="badge bg-danger">Alta</span>
                                    <?php elseif ($priority === \App\Models\Ticket::MEAN): ?>
                                        <span class="badge bg-warning">Média</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Baixa</span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <small class="text-muted d-block">Status</small>
                                    <?php $status = $ticket->getStatus(); ?>
                                    <?php if ($status === \App\Models\Ticket::OPEN): ?>
                                        <span class="badge bg-warning">Aberto</span>
                                    <?php elseif ($status === \App\Models\Ticket::IN_PROGRESS): ?>
                                        <span class="badge bg-primary">Em Andamento</span>
                                    <?php elseif ($status === \App\Models\Ticket::WAITING): ?>
                                        <span class="badge bg-info">Aguardando</span>
                                    <?php elseif ($status === \App\Models\Ticket::RESOLVED): ?>
                                        <span class="badge bg-success">Resolvido</span>
                                    <?php elseif ($status === \App\Models\Ticket::FINISHED): ?>
                                        <span class="badge bg-dark">Finalizado</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Arquivado</span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <small class="text-muted d-block">Aberto em</small>
                                    <span>
                                        <i class="bi bi-calendar-fill text-primary me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($ticket->getOpenedAt())) ?>
                                    </span>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">Descrição</small>
                                    <p class="mb-0"><?= htmlspecialchars($ticket->getDescription()) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Comentários -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-chat-dots-fill me-2"></i>
                                Comentários
                                <?php if ($comments ?? null): ?>
                                    <span class="badge bg-primary ms-1"><?= count($comments) ?></span>
                                <?php else: ?>
                                    <span class="badge bg-primary ms-1">0</span>
                                <?php endif; ?>
                            </h5>
                        </div>
                        <div class="card-body px-3 py-4">
                            <?php if (!empty($comments)): ?>
                                <?php foreach ($comments as $comment): ?>
                                    <?php
                                    $commentUser = $comment->user();
                                    $isOwn = $comment->getUserId() === $loggedUserId;
                                    $userName = htmlspecialchars($commentUser?->getName() ?? '—');
                                    $initial = strtoupper(substr($commentUser?->getName() ?? '?', 0, 1));
                                    $createdAt = $comment->getCreatedAt()
                                            ? date('d/m/Y H:i', strtotime($comment->getCreatedAt()))
                                            : '—';
                                    $role = $commentUser?->getRole();
                                    $avatarColor = $role === \App\Models\User::TECHNICAL ? '#435ebe' : '#6c757d';
                                    ?>

                                    <div class="d-flex <?= $isOwn ? 'justify-content-end' : 'justify-content-start' ?> mb-3">
                                        <div style="max-width: 75%;">

                                            <!-- Cabeçalho -->
                                            <div class="d-flex align-items-center gap-2 mb-1
                                <?= $isOwn ? 'justify-content-end' : 'justify-content-start' ?>">

                                                <?php if (!$isOwn): ?>
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center
                                        text-white fw-bold flex-shrink-0"
                                                         style="width: 28px; height: 28px; font-size: 13px;
                                                                 background: <?= $avatarColor ?>;">
                                                        <?= $initial ?>
                                                    </div>
                                                <?php endif; ?>

                                                <small class="fw-semibold text-muted"><?= $userName ?></small>
                                                <small class="text-muted" style="font-size: 11px;">
                                                    <i class="bi bi-clock me-1"></i><?= $createdAt ?>
                                                </small>

                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger py-0 px-1 flex-shrink-0"
                                                        style="font-size: 11px; line-height: 1.4;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalExcluirComment<?= $comment->getId() ?>">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>

                                                <?php if ($isOwn): ?>
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center
                                        text-white fw-bold flex-shrink-0"
                                                         style="width: 28px; height: 28px; font-size: 13px;
                                                                 background: <?= $avatarColor ?>;">
                                                        <?= $initial ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="px-3 py-2 shadow-sm"
                                                 style="
                                                         background: <?= $isOwn ? '#435ebe' : '#ffffff' ?>;
                                                         color: <?= $isOwn ? '#ffffff' : '#333333' ?>;
                                                         border: 1px solid <?= $isOwn ? '#3a50a8' : '#dee2e6' ?>;
                                                         border-radius: <?= $isOwn ? '12px 0 12px 12px' : '0 12px 12px 12px' ?>;
                                                         ">
                                                <p class="mb-0" style="font-size: 14px;">
                                                    <?= htmlspecialchars($comment->getComment()) ?>
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Modal Excluir -->
                                    <div class="modal fade text-left"
                                         id="modalExcluirComment<?= $comment->getId() ?>"
                                         tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title white">
                                                        <i class="bi bi-trash-fill me-2"></i>
                                                        Excluir Comentário
                                                    </h5>
                                                    <button type="button" class="close"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja excluir este comentário?
                                                    <br>
                                                    <small class="text-muted">Esta ação não poderá ser desfeita.</small>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                        <span class="d-none d-sm-block">Cancelar</span>
                                                    </button>
                                                    <form action="<?= url('/tecnico/chamados/' . $ticket->getId() . '/comentarios/excluir/' . $comment->getId()) ?>"
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

                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center text-muted fst-italic py-5">
                                    <i class="bi bi-chat-dots fs-2 d-block mb-2"></i>
                                    Nenhum comentário ainda. Seja o primeiro a comentar!
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Formulário Novo Comentário -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-chat-square-text-fill me-2"></i>
                                Adicionar Comentário
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/tecnico/chamados/' . $ticket->getId() . '/comentarios') ?>"
                                  method="post">
                                <?= csrf_input() ?>
                                <div class="form-group">
                                    <label for="comment" class="form-label">Comentário</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-chat-text-fill"></i>
                                        </span>
                                        <textarea name="comment" id="comment"
                                                  class="form-control"
                                                  placeholder="Digite seu comentário (mínimo 20 caracteres)"
                                                  rows="4" required><?= old('comment') ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group mt-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send-fill me-1"></i>
                                        Enviar Comentário
                                    </button>
                                    <a href="<?= url('/tecnico/chamados') ?>" class="btn btn-secondary">
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