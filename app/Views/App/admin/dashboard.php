<?= $this->layout('admin/app', [
    'title' => $title ?? "Dashboard | Admin - " . APP_NAME,
    'menuActive' => 'dashboard',
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

            <!-- Cards de resumo -->
            <div class="col-12">
                <div class="row">

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Usuários</h6>
                                        <h6 class="font-extrabold mb-0"><?= $totalUsers ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShield-Done"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Perfis</h6>
                                        <h6 class="font-extrabold mb-0"><?= $totalRoles ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldFilter"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Departamentos</h6>
                                        <h6 class="font-extrabold mb-0"><?= $totalDepartments ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldTicket"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Chamados abertos</h6>
                                        <h6 class="font-extrabold mb-0"><?= $totalOpenTickets ?? 0 ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Tabela de usuários recentes -->
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-people-fill me-2"></i>
                            Usuários recentes
                        </h5>
                        <a href="<?= url('/admin/usuarios') ?>" class="btn btn-sm btn-primary">
                            Ver todos
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Perfil</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($recentUsers)): ?>
                                    <?php foreach ($recentUsers as $user): ?>
                                        <tr>
                                            <td>
                                                <i class="bi bi-person-fill text-primary me-1"></i>
                                                <?= htmlspecialchars($user->getName()) ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    <?= htmlspecialchars($user->role()?->getName() ?? '—') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($user->getStatus() === \App\Models\User::ACTIVE): ?>
                                                    <span class="badge bg-success">Ativo</span>
                                                <?php elseif ($user->getStatus() === \App\Models\User::INACTIVE): ?>
                                                    <span class="badge bg-danger">Inativo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Registrado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted fst-italic py-3">
                                            Nenhum usuário cadastrado ainda.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de perfis cadastrados -->
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-shield-fill me-2"></i>
                            Perfis cadastrados
                        </h5>
                        <a href="<?= url('/admin/perfis') ?>" class="btn btn-sm btn-primary">
                            Ver todos
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Protegido</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($recentRoles)): ?>
                                    <?php foreach ($recentRoles as $role): ?>
                                        <tr>
                                            <td>
                                                <i class="bi bi-shield-fill text-primary me-1"></i>
                                                <?= htmlspecialchars($role->getName()) ?>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?= htmlspecialchars($role->getDescription() ?? '—') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($role->isProtected()): ?>
                                                    <span class="badge bg-danger">Sim</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Não</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted fst-italic py-3">
                                            Nenhum perfil cadastrado ainda.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
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
