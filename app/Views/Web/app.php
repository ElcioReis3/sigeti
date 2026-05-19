<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= $title ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="<?= assets_flex_start('/assets/img/favicon.png') ?>" rel="icon">
    <link href="<?= assets_flex_start('/assets/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&family=Nunito:wght@300;400;600;700&display=swap"
          rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/vendor/aos/aos.css') ?>" rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">
    <link href="<?= assets('/css/custom.css') ?>" rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/css/main.css') ?>" rel="stylesheet">
</head>
<body class="index-page">

<!-- ════════════════════════════════════════
     TOPBAR
════════════════════════════════════════ -->
<div id="sigeti-topbar" role="banner" aria-label="Barra de informações">
    <div class="tb-inner">
        <div class="tb-left">
            <div class="tb-ann">
                <span class="tb-pulse" aria-hidden="true"></span>
                <span class="tb-ann-text">SIGETI v2.0 —&nbsp;<strong>Novos relatórios de SLA disponíveis</strong></span>
            </div>
            <span class="tb-vline tb-hide-md" aria-hidden="true"></span>
            <a href="tel:+559999999999" class="tb-contact tb-hide-md" aria-label="Telefone">
                <i class="bi bi-telephone"></i>
                <span>(99) 9 9999-9999</span>
            </a>
            <span class="tb-vline tb-hide-lg" aria-hidden="true"></span>
            <a href="mailto:contato@sigeti.com.br" class="tb-contact tb-hide-lg" aria-label="E-mail">
                <i class="bi bi-envelope"></i>
                <span>contato@sigeti.com.br</span>
            </a>
        </div>
        <div class="tb-right">
            <nav class="tb-socs" aria-label="Redes sociais">
                <a href="https://wa.me/5599999999999" class="tb-si tb-si-wa" target="_blank" rel="noopener noreferrer"
                   aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                <a href="mailto:contato@sigeti.com.br" class="tb-si tb-si-em" aria-label="E-mail"><i
                            class="bi bi-envelope-fill"></i></a>
                <a href="https://instagram.com/sigeti" class="tb-si tb-si-ig" target="_blank" rel="noopener noreferrer"
                   aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://linkedin.com/company/sigeti" class="tb-si tb-si-li" target="_blank"
                   rel="noopener noreferrer" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
            </nav>
            <span class="tb-divider" aria-hidden="true"></span>
            <a href="<?= url('/entrar') ?>" target="_blank" class="tb-login">Entrar</a>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════
     HEADER / NAVBAR
════════════════════════════════════════ -->
<header id="header" class="sg-header">
    <div class="sg-header-inner">

        <!-- Logo -->
        <a href="<?= url('/') ?>" class="sg-logo" aria-label="SIGETI — página inicial">
            <img src="<?= assets_flex_start('/assets/img/logo.png') ?>" alt="SIGETI" class="sg-logo-img">
            <div class="sg-logo-text">
                <span class="sg-logo-name">SIGETI</span>
                <span class="sg-logo-sub">Gestão de TI</span>
            </div>
        </a>

        <!-- Nav desktop -->
        <nav class="sg-nav" id="sg-nav" aria-label="Navegação principal">
            <ul>
                <li><a href="<?= url('/') ?>#" class="sg-nav-active">Home</a></li>
                <li><a href="<?= url('/') ?>#about">Sobre</a></li>
                <li><a href="<?= url('/') ?>#services">Serviços</a></li>
                <li><a href="<?= url('/') ?>#team">Time</a></li>
                <li><a href="<?= url('/') ?>#contact">Contato</a></li>
            </ul>
        </nav>

        <!-- Ações direita -->
        <div class="sg-header-acts">
            <a href="" class="sg-btn-trial">Teste Grátis</a>

            <!-- Hamburger -->
            <button class="sg-hbg" id="sg-hbg" aria-label="Abrir menu" aria-expanded="false" aria-controls="sg-drawer">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <!-- Drawer mobile -->
    <div class="sg-drawer" id="sg-drawer" aria-hidden="true">
        <nav aria-label="Menu mobile">
            <ul>
                <li><a href="<?= url('/') ?>#">Home</a></li>
                <li><a href="<?= url('/') ?>#about">Sobre</a></li>
                <li><a href="<?= url('/') ?>#services">Serviços</a></li>
                <li><a href="<?= url('/') ?>#team">Time</a></li>
                <li><a href="<?= url('/') ?>#contact">Contato</a></li>
            </ul>
            <div class="sg-drawer-cta">
                <a href="<?= url('/entrar') ?>" target="_blank" class="sg-drawer-login">Entrar</a>
                <a href="" class="sg-btn-trial">Teste Grátis</a>
            </div>
            <!-- Sociais no drawer -->
            <nav class="sg-drawer-socs" aria-label="Redes sociais">
                <a href="https://wa.me/5599999999999" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i
                            class="bi bi-whatsapp"></i></a>
                <a href="mailto:contato@sigeti.com.br" aria-label="E-mail"><i class="bi bi-envelope-fill"></i></a>
                <a href="https://instagram.com/sigeti" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i
                            class="bi bi-instagram"></i></a>
                <a href="https://linkedin.com/company/sigeti" target="_blank" rel="noopener noreferrer"
                   aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
            </nav>
        </nav>
    </div>
</header>

<!-- ════════════════════════════════════════
     CONTEÚDO
════════════════════════════════════════ -->
<main class="main">
    <?= $this->section('content') ?>
</main>

<!-- ════════════════════════════════════════
     FOOTER
════════════════════════════════════════ -->
<footer id="footer" class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="row gy-5">

                <!-- Brand -->
                <div class="col-lg-4 col-md-12">
                    <a href="<?= url('/') ?>" class="ft-brand d-flex align-items-center gap-2 mb-3">
                        <div class="ft-logo-icon"><span>SG</span></div>
                        <div>
                            <div class="ft-logo-name">SIGETI</div>
                            <div class="ft-logo-sub">Sistema de Gestão de Chamados de TI</div>
                        </div>
                    </a>
                    <p class="ft-desc">Sistema inteligente de gestão de chamados de TI. Rastreabilidade total, SLA
                        automatizado e relatórios em tempo real para equipes de qualquer porte.</p>
                    <ul class="ft-contacts">
                        <li><i class="bi bi-geo-alt-fill"></i><span>Av. Luis Sales, nº 147, Ponte — Caxias, MA</span>
                        </li>
                        <li><i class="bi bi-telephone-fill"></i><a href="tel:+559989995548">+55 (99) 9 8999-5548</a>
                        </li>
                        <li><i class="bi bi-envelope-fill"></i><a href="mailto:contato@sigeti.com.br">contato@sigeti.com.br</a>
                        </li>
                    </ul>
                    <nav class="ft-socs" aria-label="Redes sociais">
                        <a href="https://wa.me/5599989995548" class="ft-sb ft-sb-wa" target="_blank"
                           rel="noopener noreferrer"><i class="bi bi-whatsapp"></i><span>WhatsApp</span></a>
                        <a href="mailto:contato@sigeti.com.br" class="ft-sb ft-sb-em"><i
                                    class="bi bi-envelope-fill"></i><span>E-mail</span></a>
                        <a href="https://instagram.com/sigeti" class="ft-sb ft-sb-ig" target="_blank"
                           rel="noopener noreferrer"><i class="bi bi-instagram"></i><span>Instagram</span></a>
                        <a href="https://linkedin.com/company/sigeti" class="ft-sb ft-sb-li" target="_blank"
                           rel="noopener noreferrer"><i class="bi bi-linkedin"></i><span>LinkedIn</span></a>
                    </nav>
                </div>

                <!-- Links -->
                <div class="col-lg-2 col-md-4 col-6">
                    <h5 class="ft-col-title">Links Úteis</h5>
                    <ul class="ft-links">
                        <li><a href="<?= url('/') ?>#">Home</a></li>
                        <li><a href="<?= url('/') ?>#about">Sobre nós</a></li>
                        <li><a href="<?= url('/') ?>#services">Serviços</a></li>
                        <li><a href="<?= url('/') ?>#team">Nossa equipe</a></li>
                        <li><a href="<?= url('/') ?>#contact">Contato</a></li>
                    </ul>
                </div>

                <!-- Serviços -->
                <div class="col-lg-2 col-md-4 col-6">
                    <h5 class="ft-col-title">Nossos Serviços</h5>
                    <ul class="ft-links">
                        <li><a href="">Abertura de Chamados</a></li>
                        <li><a href="">Gestão de Atendimentos</a></li>
                        <li><a href="">Atendimentos por Setores</a></li>
                        <li><a href="">Histórico de Chamados</a></li>
                        <li><a href="">Relatório e Indicadores</a></li>
                        <li><a href="">Controle de Acesso</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-4 col-md-4 col-12">
                    <h5 class="ft-col-title">Fique por dentro</h5>
                    <p class="ft-nl-desc">Receba novidades, dicas de gestão de TI e atualizações do sistema direto no
                        seu e-mail.</p>
                    <form class="ft-nl-form" action="" method="post" aria-label="Newsletter">
                        <label for="ft-nl-email" class="visually-hidden">Seu e-mail</label>
                        <input class="ft-nl-in" type="email" id="ft-nl-email" name="email" placeholder="seu@empresa.com"
                               required autocomplete="email">
                        <button class="ft-nl-btn" type="submit"><i class="bi bi-send-fill"></i></button>
                    </form>
                    <p class="ft-nl-note"><i class="bi bi-shield-lock"></i> Sem spam. Cancele quando quiser.</p>
                    <div class="ft-status">
                        <span class="ft-status-dot" aria-hidden="true"></span>
                        <span>Todos os sistemas operacionais</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="ft-bottom-inner">
                <p class="ft-copy">© <?= date('Y') ?> <strong>SIGETI</strong> — Sistema Inteligente de Gestão de
                    Chamados de TI. Todos os direitos reservados.</p>
                <nav class="ft-legal" aria-label="Links legais">
                    <a href="">Privacidade</a><span aria-hidden="true">·</span>
                    <a href="">Termos de uso</a><span aria-hidden="true">·</span>
                    <a href="">LGPD</a>
                </nav>
                <nav class="ft-minis" aria-label="Redes sociais">
                    <a href="https://wa.me/5599989995548" class="ft-mini ft-mi-wa" target="_blank"
                       rel="noopener noreferrer" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="mailto:contato@sigeti.com.br" class="ft-mini ft-mi-em" aria-label="E-mail"><i
                                class="bi bi-envelope"></i></a>
                    <a href="https://instagram.com/sigeti" class="ft-mini ft-mi-ig" target="_blank"
                       rel="noopener noreferrer" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://linkedin.com/company/sigeti" class="ft-mini ft-mi-li" target="_blank"
                       rel="noopener noreferrer" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                </nav>
            </div>
        </div>
    </div>
</footer>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Vendor JS -->
<script src="<?= assets_flex_start('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/php-email-form/validate.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/aos/aos.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/glightbox/js/glightbox.min.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/purecounter/purecounter_vanilla.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/isotope-layout/isotope.pkgd.min.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/swiper/swiper-bundle.min.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/js/main.js') ?>"></script>

<script>
    (function () {
        const topbar = document.getElementById('sigeti-topbar');
        const header = document.getElementById('header');

        if (topbar && header) {
            window.addEventListener('scroll', function () {
                const past = window.scrollY >= topbar.offsetHeight;
                header.classList.toggle('header-fixed', past);
                topbar.classList.toggle('topbar-hidden', past);
            }, {passive: true});
        }

        const hbg = document.getElementById('sg-hbg');
        const drawer = document.getElementById('sg-drawer');

        if (hbg && drawer) {
            hbg.addEventListener('click', function () {
                const open = drawer.classList.toggle('open');
                hbg.classList.toggle('open', open);
                hbg.setAttribute('aria-expanded', open);
                drawer.setAttribute('aria-hidden', !open);
                document.body.style.overflow = open ? 'hidden' : '';
            });

            drawer.querySelectorAll('a').forEach(function (a) {
                a.addEventListener('click', function () {
                    drawer.classList.remove('open');
                    hbg.classList.remove('open');
                    hbg.setAttribute('aria-expanded', 'false');
                    drawer.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                });
            });

            document.addEventListener('click', function (e) {
                if (!header.contains(e.target)) {
                    drawer.classList.remove('open');
                    hbg.classList.remove('open');
                    hbg.setAttribute('aria-expanded', 'false');
                    drawer.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }
            });
        }
    })();
</script>
</body>
</html>