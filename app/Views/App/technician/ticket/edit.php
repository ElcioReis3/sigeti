<?= $this->layout('technician/app', [
        "title" => $title ?? "Técnico | Editar Chamado - " . APP_NAME,
        "menuActive" => "chamados",
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
                    <h3>Editar Chamado</h3>
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
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?= \App\Core\Message::render() ?>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">

                    <!-- Card somente leitura -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-ticket-detailed-fill me-2"></i>
                                Informações do Chamado
                            </h5>
                            <a href="<?= url('/tecnico/chamados/' . $ticket->getId()) . '/comentarios' ?>"
                               class="btn btn-sm btn-info">
                                <i class="bi bi-pencil-fill me-1"></i> Comentar
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <small class="text-muted d-block">Título</small>
                                    <span><i class="bi bi-card-heading text-primary me-1"></i>
                                        <?= htmlspecialchars($ticket->getTitle()) ?>
                                    </span>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <small class="text-muted d-block">Departamento</small>
                                    <span><i class="bi bi-building text-primary me-1"></i>
                                        <?= htmlspecialchars($ticket->department()?->getName() ?? '—') ?>
                                    </span>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <small class="text-muted d-block">Solicitante</small>
                                    <span><i class="bi bi-person-fill text-primary me-1"></i>
                                        <?= htmlspecialchars($ticket->openedBy()?->getName() ?? '—') ?>
                                    </span>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <small class="text-muted d-block">Categoria</small>
                                    <span><i class="bi bi-tag-fill text-primary me-1"></i>
                                        <?= htmlspecialchars($ticket->category()?->getName() ?? '—') ?>
                                    </span>
                                </div>
                                <div class="col-12 mb-3">
                                    <small class="text-muted d-block">Descrição</small>
                                    <span><?= htmlspecialchars($ticket->getDescription()) ?></span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <small class="text-muted d-block">Aberto em</small>
                                    <span><i class="bi bi-calendar-fill text-primary me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($ticket->getOpenedAt())) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card editável -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="bi bi-pencil-fill me-2"></i>
                                Atualizar Chamado
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/tecnico/chamados/editar/' . $ticket->getId()) ?>" method="post">

                                <?= csrf_input() ?>

                                <input type="hidden" name="_method" value="PUT">

                                <input type="hidden" name="id" value="<?= $ticket->getId() ?>">

                                <div class="row">
                                    <!-- Técnico Responsável -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="assigned_to" class="form-label">Técnico Responsável</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                            class="bi bi-person-badge-fill"></i></span>
                                                <select name="assigned_to" id="assigned_to" class="form-select">
                                                    <option value="">— Sem técnico atribuído —</option>
                                                    <?php foreach ($technicians as $technician): ?>
                                                        <option value="<?= old('assigned_to', $technician->getId())?>"
                                                                <?= $ticket->getAssignedTo() == $technician->getId() ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($technician->getName()) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Prioridade -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="priority" class="form-label">Prioridade</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-flag-fill"></i></span>
                                                <select name="priority" id="priority" class="form-select" required>
                                                    <option value="baixa" <?= $ticket->getPriority() === \App\Models\Ticket\Ticket::LOW ? 'selected' : '' ?>>
                                                        Baixa
                                                    </option>
                                                    <option value="media" <?= $ticket->getPriority() === \App\Models\Ticket\Ticket::MEAN ? 'selected' : '' ?>>
                                                        Média
                                                    </option>
                                                    <option value="alta" <?= $ticket->getPriority() === \App\Models\Ticket\Ticket::HIGH ? 'selected' : '' ?>>
                                                        Alta
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-activity"></i></span>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="aberto" <?= $ticket->getStatus() === \App\Models\Ticket\Ticket::OPEN ? 'selected' : '' ?>>
                                                Aberto
                                            </option>
                                            <option value="em_andamento" <?= $ticket->getStatus() === \App\Models\Ticket\Ticket::IN_PROGRESS ? 'selected' : '' ?>>
                                                Em Andamento
                                            </option>
                                            <option value="aguardando" <?= $ticket->getStatus() === \App\Models\Ticket\Ticket::WAITING ? 'selected' : '' ?>>
                                                Aguardando
                                            </option>
                                            <option value="resolvido" <?= $ticket->getStatus() === \App\Models\Ticket\Ticket::RESOLVED ? 'selected' : '' ?>>
                                                Resolvido
                                            </option>
                                            <option value="finalizado" <?= $ticket->getStatus() === \App\Models\Ticket\Ticket::FINISHED ? 'selected' : '' ?>>
                                                Finalizado
                                            </option>
                                            <option value="arquivado" <?= $ticket->getStatus() === \App\Models\Ticket\Ticket::ARCHIVED ? 'selected' : '' ?>>
                                                Arquivado
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="form-group mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Atualizar
                                    </button>
                                    <a href="<?= url('/tecnico/chamados') ?>" class="btn btn-secondary">
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