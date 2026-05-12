<?= $this->layout('admin/app', [
        'title' => $title ?? "Admin | Editar Perfil - " . APP_NAME,
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
                    <h3>Editar Perfil</h3>
                    <p class="text-subtitle text-muted">
                        Alterando informações de <strong><?= htmlspecialchars($role->getName()) ?></strong>
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/tecnico/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/admin/perfis') ?>">Perfis</a></li>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="bi bi-shield-fill me-2"></i>
                                Informações do Perfil
                            </h4>
                            <a href="<?= url('/admin/perfis/' . $role->getId() . '/permissoes') ?>"
                               class="btn btn-sm btn-info">
                                <i class="bi bi-key-fill me-1"></i>
                                Gerenciar Permissões
                            </a>
                        </div>
                        <div class="card-body">

                            <?php if ($role->isProtected()): ?>
                                <div class="alert alert-warning">
                                    <i class="bi bi-lock-fill me-2"></i>
                                    Este perfil é <strong>protegido</strong> e não pode ser editado.
                                </div>
                            <?php else: ?>

                                <form action="<?= url('/admin/perfis/editar/' . $role->getId()) ?>" method="post">
                                    <?= csrf_input() ?>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="id" value="<?= $role->getId() ?>">

                                    <div class="form-group">
                                        <label for="name" class="form-label">Nome do perfil</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-shield-fill"></i>
                                            </span>
                                            <input type="text" name="name" id="name"
                                                   class="form-control"
                                                   value="<?= old('name', htmlspecialchars($role->getName())) ?>"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="form-label">Descrição</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-card-text"></i>
                                            </span>
                                            <textarea name="description" id="description"
                                                      class="form-control"
                                                      rows="3"><?= old('description', htmlspecialchars($role->getDescription() ?? '')) ?></textarea>
                                        </div>
                                        <small class="text-muted">Campo opcional.</small>
                                    </div>

                                    <div class="form-group mt-4 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Atualizar
                                        </button>
                                        <a href="<?= url('/admin/perfis') ?>" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left-circle-fill me-1"></i>
                                            Cancelar
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