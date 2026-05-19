<?= $this->layout($layout, [
        'title' => $title ?? "Perfil - " . APP_NAME,
        'menuActive' => 'conta',
        'submenuActive' => 'perfil',
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
                    <h3>Perfil</h3>
                    <p class="text-subtitle text-muted">Gerencie as informações do seu perfil</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Perfil</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <?= \App\Core\Message::render() ?>

        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <img src="<?= assets_mazer('/assets/compiled/jpg/2.jpg') ?>"
                                     alt="Avatar"
                                     class="rounded-circle"
                                     style="width: 160px; height: 160px; object-fit: cover; border: 4px solid #435ebe;">
                                <h4 class="mt-3 mb-1"><?= htmlspecialchars($user->getName()) ?></h4>
                                <p class="text-muted mb-1"><?= htmlspecialchars($user->role()?->getName() ?? '—') ?></p>
                                <p class="text-muted">
                                    <i class="bi bi-envelope-fill me-1"></i>
                                    <?= htmlspecialchars($user->getEmail()) ?>
                                </p>
                            </div>
                            <hr>
                            <div class="d-flex flex-column gap-2">
                                <a href="<?= url('/perfil') ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-person-fill me-1"></i>
                                    Informações Pessoais
                                </a>
                                <a href="<?= url('/seguranca') ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-lock-fill me-1"></i>
                                    Segurança
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informações Pessoais</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/perfil') ?>" method="post">
                                <?= csrf_input() ?>

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
                                        <input disabled type="email" class="form-control"
                                               value="<?= htmlspecialchars($user->getEmail()) ?>">
                                    </div>
                                    <small class="text-muted">O email não pode ser alterado.</small>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Telefone</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                            class="bi bi-telephone-fill"></i></span>
                                                <input type="text" name="phone" id="phone"
                                                       class="form-control"
                                                       value="<?= old('phone', htmlspecialchars($profile?->getPhone() ?? '')) ?>"
                                                       placeholder="(00) 00000-0000">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="extension" class="form-label">Ramal</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-telephone-plus-fill"></i></span>
                                                <input type="text" name="extension" id="extension"
                                                       class="form-control"
                                                       value="<?= old('extension', htmlspecialchars($profile?->getExtension() ?? '')) ?>"
                                                       placeholder="Ex: 1234">
                                            </div>
                                            <small class="text-muted">Campo opcional.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="gender" class="form-label">Gênero</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                            class="bi bi-gender-ambiguous"></i></span>
                                                <select name="gender" id="gender" class="form-select">
                                                    <option value=""
                                                            disabled <?= empty($profile?->getGender()) ? 'selected' : '' ?>>
                                                        Selecione
                                                    </option>
                                                    <option value="masculino" <?= $profile?->getGender() === 'masculino' ? 'selected' : '' ?>>
                                                        Masculino
                                                    </option>
                                                    <option value="feminino" <?= $profile?->getGender() === 'feminino' ? 'selected' : '' ?>>
                                                        Feminino
                                                    </option>
                                                    <option value="nao_binario" <?= $profile?->getGender() === 'nao_binario' ? 'selected' : '' ?>>
                                                        Não binário
                                                    </option>
                                                    <option value="prefiro_nao_informar" <?= $profile?->getGender() === 'prefiro_nao_informar' ? 'selected' : '' ?>>
                                                        Prefiro não informar
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="birth_date" class="form-label">Data de Nascimento</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                            class="bi bi-calendar-fill"></i></span>
                                                <input type="date" name="birth_date" id="birth_date"
                                                       class="form-control"
                                                       value="<?= old('birth_date', $profile?->getBirthDate() ?? '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="job_title" class="form-label">Cargo</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                            class="bi bi-briefcase-fill"></i></span>
                                                <input type="text" name="job_title" id="job_title"
                                                       class="form-control"
                                                       value="<?= old('job_title', htmlspecialchars($profile?->getJobTitle() ?? '')) ?>"
                                                       placeholder="Ex: Professor, Analista de TI">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="registration" class="form-label">Matrícula</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                                <input type="text" name="registration" id="registration"
                                                       class="form-control"
                                                       value="<?= old('registration', htmlspecialchars($profile?->getRegistration() ?? '')) ?>"
                                                       placeholder="Número de matrícula">
                                            </div>
                                            <small class="text-muted">Campo opcional.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="specialty" class="form-label">Especialidade</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-star-fill"></i></span>
                                        <input type="text" name="specialty" id="specialty"
                                               class="form-control"
                                               value="<?= old('specialty', htmlspecialchars($profile?->getSpecialty() ?? '')) ?>"
                                               placeholder="Ex: Infraestrutura, Suporte, Desenvolvimento">
                                    </div>
                                    <small class="text-muted">Campo opcional.</small>
                                </div>

                                <div class="form-group">
                                    <label for="bio" class="form-label">Bio</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-chat-quote-fill"></i></span>
                                        <textarea name="bio" id="bio"
                                                  class="form-control"
                                                  rows="3"
                                                  placeholder="Uma breve apresentação sobre você"><?= old('bio', htmlspecialchars($profile?->getBio() ?? '')) ?></textarea>
                                    </div>
                                    <small class="text-muted">Campo opcional. Máximo 1000 caracteres.</small>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="city" class="form-label">Cidade</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                                <input type="text" name="city" id="city"
                                                       class="form-control"
                                                       value="<?= old('city', htmlspecialchars($profile?->getCity() ?? '')) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="state" class="form-label">Estado</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-map-fill"></i></span>
                                                <input type="text" name="state" id="state"
                                                       class="form-control"
                                                       value="<?= old('state', htmlspecialchars($profile?->getState() ?? '')) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="country" class="form-label">País</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                                <input type="text" name="country" id="country"
                                                       class="form-control"
                                                       value="<?= old('country', htmlspecialchars($profile?->getCountry() ?? 'Brasil')) ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Salvar Alterações
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
