<?= $this->layout('admin/app', [
        'title' => $title ?? "Admin | Permissões - " . APP_NAME,
        'menuActive' => 'perfis',
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
                    <h3>Permissões</h3>
                    <p class="text-subtitle text-muted">
                        Gerenciando permissões de <strong><?= htmlspecialchars($role->getName()) ?></strong>
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/admin/perfis') ?>">Perfis</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Permissões</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?= \App\Core\Message::render() ?>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="bi bi-key-fill me-2"></i>
                                Permissões do Perfil
                            </h4>
                            <a href="<?= url('/admin/perfis/editar/' . $role->getId()) ?>"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-fill me-1"></i>
                                Editar Perfil
                            </a>
                        </div>
                        <div class="card-body">

                            <?php if ($role->isProtected()): ?>
                                <div class="alert alert-warning">
                                    <i class="bi bi-lock-fill me-2"></i>
                                    As permissões deste perfil são <strong>protegidas</strong> e não podem ser
                                    alteradas.
                                </div>
                            <?php else: ?>

                                <form action="<?= url('/admin/perfis/' . $role->getId() . '/permissoes') ?>"
                                      method="post">
                                    <?= csrf_input() ?>
                                    <input type="hidden" name="id" value="<?= $role->getId() ?>">

                                    <?php foreach ($permissions as $groupName => $groupPermissions): ?>
                                        <div class="mb-4">
                                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                                <i class="bi bi-folder-fill me-1"></i>
                                                <?= htmlspecialchars($groupName) ?>
                                            </h6>
                                            <div class="row">
                                                <?php foreach ($groupPermissions as $permission): ?>
                                                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                   type="checkbox"
                                                                   name="permissions[]"
                                                                   value="<?= $permission['id'] ?>"
                                                                   id="perm_<?= $permission['id'] ?>"
                                                                    <?php if (in_array($permission['id'], $currentPermissions)): ?>
                                                                        checked
                                                                    <?php endif; ?>>
                                                            <label class="form-check-label"
                                                                   for="perm_<?= $permission['id'] ?>">
                                                                <?= htmlspecialchars($permission['label']) ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="form-group mt-4 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Salvar Permissões
                                        </button>
                                        <a href="<?= url('/admin/perfis') ?>" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left-circle-fill me-1"></i>
                                            Voltar
                                        </a>
                                    </div>
                                </form>

                            <?php endif; ?>

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