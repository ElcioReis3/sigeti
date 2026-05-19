<?= $this->layout('teacher/app', [
        "title" => $title ?? "Solicitante | Novo Chamado - " . APP_NAME,
        "menuActive" => "chamados",
        "submenuActive" => "novo",
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
                    <h3>Novo Chamado</h3>
                    <p class="text-subtitle text-muted">Preencha as informações para abrir um novo chamado</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/professor/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/professor/chamados') ?>">Chamados</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Novo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?= \App\Core\Message::render() ?>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="bi bi-ticket-detailed-fill me-2"></i>
                                Informações do Chamado
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/professor/chamados/cadastrar') ?>" method="post">

                                <?= csrf_input() ?>

                                <!-- Título -->
                                <div class="form-group">
                                    <label for="title" class="form-label">Título</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                        <input type="text" name="title" id="title"
                                               class="form-control"
                                               placeholder="Título do chamado (mínimo 10 caracteres)"
                                               required>
                                    </div>
                                </div>

                                <!-- Descrição -->
                                <div class="form-group">
                                    <label for="description" class="form-label">Descrição</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <textarea name="description" id="description"
                                                  class="form-control"
                                                  placeholder="Descreva o problema (mínimo 30 caracteres)"
                                                  rows="4" required></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Categoria -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="category_id" class="form-label">Categoria</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                                                <select name="category_id" id="category_id" class="form-select"
                                                        required>
                                                    <option value="" disabled selected>Selecione a categoria</option>
                                                    <?php if ($categories): ?>
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?= $category->getId() ?>">
                                                                <?= htmlspecialchars($category->getName()) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <option value="">Nenhuma categoria para selecionar</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Escola -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="department_id" class="form-label">Departamento</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                                <select name="department_id" id="department_id" class="form-select" required>
                                                    <option value="" disabled selected>Selecione o departamento</option>
                                                    <?php if ($departments): ?>
                                                        <?php foreach ($departments as $department): ?>
                                                            <option value="<?= $department->getId() ?>">
                                                                <?= htmlspecialchars($department->getName()) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <option value="">Nenhum departamento para selecionar</option>
                                                    <?php endif; ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="form-group mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Abrir Chamado
                                    </button>
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