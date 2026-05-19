<?= $this->layout('technician/app', [
        'title' => $title ?? "Dashboard | Técnico - " . APP_NAME,
        'menuActive' => 'dashboard'
]) ?>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>

    <?= \App\Core\Message::render() ?>

    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-2 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Abertos</h6>
                                        <h6 class="font-extrabold mb-0"><?= $quantityTicketsByStatus[\App\Models\Ticket\Ticket::OPEN] ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Andamento</h6>
                                        <h6 class="font-extrabold mb-0"><?= $quantityTicketsByStatus[\App\Models\Ticket\Ticket::IN_PROGRESS] ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Aguardando</h6>
                                        <h6 class="font-extrabold mb-0"><?= $quantityTicketsByStatus[\App\Models\Ticket\Ticket::WAITING] ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Resolvidos</h6>
                                        <h6 class="font-extrabold mb-0"><?= $quantityTicketsByStatus[\App\Models\Ticket\Ticket::RESOLVED] ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Finalizados</h6>
                                        <h6 class="font-extrabold mb-0"><?= $quantityTicketsByStatus[\App\Models\Ticket\Ticket::FINISHED] ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-2 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Arquivados</h6>
                                        <h6 class="font-extrabold mb-0"><?= $quantityTicketsByStatus[\App\Models\Ticket\Ticket::ARCHIVED] ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Chamados <strong>por Mês</strong></h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-tickets-month"></div>
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="col-lg-4">-->
                    <!--                        <div class="card">-->
                    <!--                            <div class="card-header">-->
                    <!--                                <h4>Taxa de <strong>Resolução</strong></h4>-->
                    <!--                            </div>-->
                    <!--                            <div class="card-body">-->
                    <!--                                <div id="chart-resolution-rate"></div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Chamados por <strong>Categoria</strong></h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-tickets-category"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tempo Médio de <strong>Resolução</strong></h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-avg-resolution"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Chamados por <strong>Prioridade e Status</strong></h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-tickets-priority"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Chamados <strong>por Prioridade</strong>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                                <th>Departamento</th>
                                <th>Professor</th>
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
                                            <div class="d-flex gap-1 flex-wrap">
                                                <a href="<?= url('/tecnico/chamados/editar/' . $ticket->getId()) ?>"
                                                   class="btn btn-sm btn-warning"
                                                   title="Editar">
                                                    <i class="bi bi-pencil-fill"></i>
                                                    <span class="d-none d-xl-inline ms-1">Editar</span>
                                                </a>
                                                <a href="<?= url('/tecnico/chamados/' . $ticket->getId() . '/comentarios') ?>"
                                                   class="btn btn-sm btn-info"
                                                   title="Comentar">
                                                    <i class="bi bi-chat-dots-fill"></i>
                                                    <span class="d-none d-xl-inline ms-1">Comentar</span>
                                                </a>
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
        <!-- Basic Tables end -->

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

    <script>
        window.dashboardData = {
            quantityTicketsByMonth: <?= json_encode($quantityTicketsByMonth) ?>,
            quantityTicketsByCategory: <?= json_encode($quantityTicketsByCategory) ?>,
            resolutionRate: <?= json_encode($resolutionRate) ?>,
            avgResolutionDays: <?= json_encode($avgResolutionDays) ?>,
            ticketsByPriorityAndStatus: <?= json_encode($ticketsByPriorityAndStatus) ?>,
        };
    </script>
</div>