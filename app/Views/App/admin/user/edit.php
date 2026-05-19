<?= $this->layout('admin/app', [
        'title' => $title ?? "Admin | Editar Usuário - " . APP_NAME,
        'menuActive' => 'usuarios',
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
                    <h3>Editar Usuário</h3>
                    <p class="text-subtitle text-muted">
                        Alterando informações de <strong><?= htmlspecialchars($user->getName()) ?></strong>
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= url('/admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= url('/admin/usuarios') ?>">Usuários</a></li>
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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="bi bi-pencil-fill me-2"></i>
                                Editar Usuário
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/usuarios/editar/' . $user->getId()) ?>" method="post">
                                <?= csrf_input() ?>
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id" value="<?= $user->getId() ?>">

                                <div class="form-group">
                                    <label for="name" class="form-label">Nome Completo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" name="name" id="name"
                                               class="form-control"
                                               value="<?= old('name', htmlspecialchars($user->getName())) ?>"
                                               required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                        <input type="email" name="email" id="email"
                                               class="form-control"
                                               value="<?= old('email', htmlspecialchars($user->getEmail())) ?>"
                                               required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" name="password" id="password"
                                               class="form-control"
                                               placeholder="Digite apenas se quiser alterar">
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="bi bi-eye-fill" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Deixe em branco para manter a senha atual.</small>
                                </div>

                                <div class="form-group">
                                    <label for="document" class="form-label">CPF</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" name="document" id="document"
                                               class="form-control"
                                               value="<?= old('document', htmlspecialchars($user->getDocument() ?? '')) ?>"
                                               placeholder="Somente números (11 dígitos)"
                                               maxlength="11">
                                    </div>
                                    <small class="text-muted">Campo opcional.</small>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="role_id" class="form-label">Perfil</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-shield-fill"></i></span>
                                                <select name="role_id" id="role_id" class="form-select" required>
                                                    <?php foreach ($roles as $role): ?>
                                                        <option value="<?= $role->getId() ?>"
                                                                <?= $user->getRoleId() === $role->getId() ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($role->getName()) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="registrado" <?= $user->getStatus() === \App\Models\User::REGISTERED ? 'selected' : '' ?>>
                                                        Registrado
                                                    </option>
                                                    <option value="ativo" <?= $user->getStatus() === \App\Models\User::ACTIVE ? 'selected' : '' ?>>
                                                        Ativo
                                                    </option>
                                                    <option value="inativo" <?= $user->getStatus() === \App\Models\User::INACTIVE ? 'selected' : '' ?>>
                                                        Inativo
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="departmentLinks"
                                     style="display: <?= in_array($user->role()?->getName(), ['Técnico', 'Administrador']) ? 'none' : 'block' ?>;">
                                    <hr>
                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-building me-1"></i>
                                        Departamentos
                                    </h6>
                                    <div id="departmentLinksList">
                                        <?php if (!empty($userDepartments)): ?>
                                            <?php foreach ($userDepartments as $index => $link): ?>
                                                <div class="department-link-row row mb-2">
                                                    <div class="col-12 col-md-7 mb-2 mb-md-0">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                        class="bi bi-building"></i></span>
                                                            <select name="departments[<?= $index ?>][department_id]"
                                                                    class="form-select">
                                                                <option value="" disabled>Selecione o departamento</option>
                                                                <?php foreach ($departments as $department): ?>
                                                                    <option value="<?= $department->getId() ?>"
                                                                            <?= $link->getDepartmentId() == $department->getId() ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($department->getName()) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if ($index > 0): ?>
                                                        <div class="col-12 col-md-1 d-flex align-items-center mt-2 mt-md-0">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-danger remove-row">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="department-link-row row mb-2">
                                                <div class="col-12 col-md-7 mb-2 mb-md-0">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                    class="bi bi-building"></i></span>
                                                        <select name="departments[0][department_id]" class="form-select">
                                                            <option value="">Selecione o departamento</option>
                                                            <?php if (!empty($departments)): ?>
                                                                <?php foreach ($departments as $department): ?>
                                                                    <option value="<?= $department->getId() ?>">
                                                                        <?= htmlspecialchars($department->getName()) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <option disabled value="">Nenhum departamento cadastrado
                                                                </option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="addDepartmentLink">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Adicionar outro departamento
                                    </button>
                                </div>

                                <div class="form-group mt-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Atualizar
                                    </button>
                                    <a href="<?= url('/admin/usuarios') ?>" class="btn btn-secondary">
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

<script>
    const roleSelect = document.getElementById('role_id');
    const departmentLinks = document.getElementById('departmentLinks');
    const departmentLinksList = document.getElementById('departmentLinksList');
    let rowIndex = <?= max(count($userdepartments ?? []), 1) ?>;
    const departmentOptions = `<?php foreach ($departments as $department): ?><option value="<?= $department->getId() ?>"><?= htmlspecialchars($department->getName()) ?></option><?php endforeach; ?>`;

    const hideFor = ['Administrador'];

    const initialRoleText = roleSelect.options[roleSelect.selectedIndex].text;
    if (hideFor.includes(initialRoleText)) {
        departmentLinksList.querySelectorAll('select').forEach(function (select) {
            select.value = '';
        });
    }

    roleSelect.addEventListener('change', function () {
        const selectedText = this.options[this.selectedIndex].text;
        if (hideFor.includes(selectedText)) {
            departmentLinks.style.display = 'none';
            departmentLinksList.querySelectorAll('select').forEach(function (select) {
                select.value = '';
            });
        } else {
            departmentLinks.style.display = 'block';
        }
    });

    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
        }
    });

    document.getElementById('addDepartmentLink').addEventListener('click', function () {
        const row = document.createElement('div');
        row.className = 'department-link-row row mb-2';
        row.innerHTML = `
        <div class="col-12 col-md-7 mb-2 mb-md-0">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-building"></i></span>
                <select name="departments[${rowIndex}][department_id]" class="form-select">
                    <option value="">Selecione o departamento</option>
                    ${departmentOptions}
                </select>
            </div>
        </div>
        <div class="col-12 col-md-1 d-flex align-items-center mt-2 mt-md-0">
            <button type="button" class="btn btn-sm btn-danger remove-row">
                <i class="bi bi-trash-fill"></i>
            </button>
        </div>`;
        departmentLinksList.appendChild(row);
        rowIndex++;
        row.querySelector('.remove-row').addEventListener('click', () => row.remove());
    });

    document.querySelectorAll('.remove-row').forEach(btn => {
        btn.addEventListener('click', () => btn.closest('.department-link-row').remove());
    });
</script>