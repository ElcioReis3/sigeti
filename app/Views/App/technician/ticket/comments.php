<?= $this->layout('technician/app', [
        "title" => $title ?? "Técnico | Comentários - " . APP_NAME,
        "menuActive" => "chamados",
        "submenuActive" => "todos",
]) ?>

<?php $loggedUserId = \App\Core\Auth::user()->id; ?>

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
                                    <small class="text-muted d-block">Departamento</small>
                                    <span>
                                        <i class="bi bi-building text-primary me-1"></i>
                                        <?= htmlspecialchars($ticket->department()?->getName() ?? '—') ?>
                                    </span>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <small class="text-muted d-block">Solicitante</small>
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
                                    <?php if ($priority === \App\Models\Ticket\Ticket::LOW): ?>
                                        <span class="badge bg-danger">Alta</span>
                                    <?php elseif ($priority === \App\Models\Ticket\Ticket::MEAN): ?>
                                        <span class="badge bg-warning">Média</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Baixa</span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <small class="text-muted d-block">Status</small>
                                    <?php $status = $ticket->getStatus(); ?>
                                    <?php if ($status === \App\Models\Ticket\Ticket::OPEN): ?>
                                        <span class="badge bg-warning">Aberto</span>
                                    <?php elseif ($status === \App\Models\Ticket\Ticket::IN_PROGRESS): ?>
                                        <span class="badge bg-primary">Em Andamento</span>
                                    <?php elseif ($status === \App\Models\Ticket\Ticket::WAITING): ?>
                                        <span class="badge bg-info">Aguardando</span>
                                    <?php elseif ($status === \App\Models\Ticket\Ticket::RESOLVED): ?>
                                        <span class="badge bg-success">Resolvido</span>
                                    <?php elseif ($status === \App\Models\Ticket\Ticket::FINISHED): ?>
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
                                <?php if (!empty($comments)): ?>
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
                                    $roleName = $commentUser?->role()?->getName();
                                    $avatarColor = $roleName === 'Técnico' ? '#435ebe' : '#6c757d';
                                    ?>
                                    <div class="d-flex <?= $isOwn ? 'justify-content-end' : 'justify-content-start' ?> mb-3">
                                        <div style="max-width: 75%;">
                                            <div class="d-flex align-items-center gap-2 mb-1 <?= $isOwn ? 'justify-content-end' : 'justify-content-start' ?>">
                                                <?php if (!$isOwn): ?>
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                                         style="width: 28px; height: 28px; font-size: 13px; background: <?= $avatarColor ?>;">
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
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                                         style="width: 28px; height: 28px; font-size: 13px; background: <?= $avatarColor ?>;">
                                                        <?= $initial ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="px-3 py-2 shadow-sm"
                                                 style="background: <?= $isOwn ? '#435ebe' : '#ffffff' ?>; color: <?= $isOwn ? '#ffffff' : '#333333' ?>; border: 1px solid <?= $isOwn ? '#3a50a8' : '#dee2e6' ?>; border-radius: <?= $isOwn ? '12px 0 12px 12px' : '0 12px 12px 12px' ?>;">
                                                <p class="mb-0" style="font-size: 14px;">
                                                    <?= htmlspecialchars($comment->getComment()) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Excluir Comentário -->
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

                    <!-- Anexos -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-paperclip me-2"></i>
                                Anexos
                                <?php if (!empty($attachments)): ?>
                                    <span class="badge bg-secondary ms-1"><?= count($attachments) ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary ms-1">0</span>
                                <?php endif; ?>
                            </h5>
                            <small class="text-muted">
                                Máximo <?= TICKET_MAX_ATTACHMENTS ?> anexos — JPG, PNG, WEBP, PDF, DOC, DOCX — até 5MB
                                cada
                            </small>
                        </div>
                        <div class="card-body">

                            <?php if (!empty($attachments)): ?>
                                <div class="row mb-4">
                                    <?php foreach ($attachments as $attachment): ?>
                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="d-flex align-items-center gap-3 p-3 border rounded">
                                                <?php if ($attachment->isImage()): ?>
                                                    <i class="bi bi-file-image-fill text-primary fs-4 flex-shrink-0"></i>
                                                <?php else: ?>
                                                    <i class="bi bi-file-earmark-fill text-secondary fs-4 flex-shrink-0"></i>
                                                <?php endif; ?>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="mb-0 fw-semibold text-truncate" style="font-size: 13px;">
                                                        <?= htmlspecialchars($attachment->getOriginalName()) ?>
                                                    </p>
                                                    <small class="text-muted">
                                                        <?= number_format($attachment->getFileSize() / 1024, 1) ?> KB
                                                        —
                                                        <?= $attachment->getCreatedAt()
                                                                ? date('d/m/Y H:i', strtotime($attachment->getCreatedAt()))
                                                                : '—' ?>
                                                    </small>
                                                </div>
                                                <div class="d-flex gap-1 flex-shrink-0">
                                                    <a href="<?= url('/tecnico/chamados/' . $ticket->getId() . '/anexos/download/' . $attachment->getId()) ?>"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Baixar">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Excluir"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalExcluirAnexo<?= $attachment->getId() ?>">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Excluir Anexo -->
                                        <div class="modal fade text-left"
                                             id="modalExcluirAnexo<?= $attachment->getId() ?>"
                                             tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title white">
                                                            <i class="bi bi-trash-fill me-2"></i>
                                                            Excluir Anexo
                                                        </h5>
                                                        <button type="button" class="close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Tem certeza que deseja excluir o anexo
                                                        <strong><?= htmlspecialchars($attachment->getOriginalName()) ?></strong>?
                                                        <br>
                                                        <small class="text-muted">Esta ação não poderá ser
                                                            desfeita.</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                                data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Cancelar</span>
                                                        </button>
                                                        <form action="<?= url('/tecnico/chamados/' . $ticket->getId() . '/anexos/excluir/' . $attachment->getId()) ?>"
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
                                </div>
                            <?php else: ?>
                                <p class="text-muted fst-italic mb-4">
                                    <i class="bi bi-paperclip me-1"></i>
                                    Nenhum anexo enviado ainda.
                                </p>
                            <?php endif; ?>

                            <?php if (count($attachments ?? []) < TICKET_MAX_ATTACHMENTS): ?>
                                <form action="<?= url('/tecnico/chamados/' . $ticket->getId() . '/anexos') ?>"
                                      method="post"
                                      enctype="multipart/form-data">
                                    <?= csrf_input() ?>
                                    <div class="form-group">
                                        <label for="attachment" class="form-label">Enviar novo anexo</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-paperclip"></i>
                                            </span>
                                            <input type="file" name="attachment" id="attachment"
                                                   class="form-control"
                                                   accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx"
                                                   required>
                                        </div>
                                        <small class="text-muted">
                                            Formatos aceitos: JPG, PNG, WEBP, PDF, DOC, DOCX — Tamanho máximo: 5MB
                                        </small>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-upload me-1"></i>
                                            Enviar Anexo
                                        </button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-warning mb-0">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Este chamado atingiu o limite máximo de <?= TICKET_MAX_ATTACHMENTS ?> anexos.
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