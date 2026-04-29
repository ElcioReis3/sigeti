<?= $this->layout("app", [
        "title" => $title
]) ?>

<!-- Hero Section -->
<section id="hero" class="hero section">

    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-justify">
                <h1 data-aos="fade-up">Gerencie chamados de forma simples, rápida e eficiente</h1>
                <p data-aos="fade-up" data-aos-delay="100"> O SIGETI é um sistema completo para controle de
                    chamados, suporte técnico e atendimento, ajudando sua equipe a organizar demandas, acompanhar
                    atendimentos e aumentar a produtividade.</p>
                <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                    <a href="#about" class="btn-get-started">Começar agora <i class="bi bi-arrow-right"></i></a>
                    <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                       class="glightbox btn-watch-video d-flex align-items-center justify-content-center ms-0 ms-md-4 mt-4 mt-md-0"><i
                                class="bi bi-play-circle"></i><span>Veja como funciona</span></a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                <img src="<?= assets_flex_start('/assets/img/hero-img.png') ?>" class="img-fluid animated" alt="">
            </div>
        </div>
    </div>

</section>
<!-- /Hero Section -->

<!-- About Section -->
<section id="about" class="about section">

    <div class="container" data-aos="fade-up">
        <div class="row gx-0">

            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <div class="content text-justify">
                    <h3>Sobre o SIGETI</h3>
                    <h2>Uma solução completa para gestão de chamados e suporte técnico.</h2>
                    <p>
                        O SIGETI CAX foi desenvolvido para facilitar o controle de chamados, melhorar a organização
                        das demandas e otimizar o atendimento em equipes de suporte.
                        Com uma interface simples e eficiente, o sistema permite registrar, acompanhar e gerenciar
                        solicitações em tempo real.
                    </p>

                    <p>
                        Ideal para escolas, empresas e equipes de TI, o SIGETI ajuda a reduzir falhas na
                        comunicação, aumentar a produtividade e garantir que nenhum chamado seja perdido.
                    </p>
                    <div class="text-center text-lg-start">
                        <a href=""
                           class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                            <span>Conhecer mais</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                <img src="<?= assets_flex_start('/assets/img/about.jpg') ?>" class="img-fluid" alt="">
            </div>

        </div>
    </div>

</section>
<!-- /About Section -->

<!-- Stats Section -->
<section id="stats" class="stats section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

            <div class="col-lg-3 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-emoji-smile color-blue flex-shrink-0"></i>
                    <div>
                        <span data-purecounter-end="120">120</span>
                        <p>Chamados gerenciados</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-journal-richtext color-orange flex-shrink-0" style="color: #ee6c20;"></i>
                    <div>
                        <span data-purecounter-end="45">45</span>
                        <p>Usuários atendidos</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-headset color-green flex-shrink-0" style="color: #15be56;"></i>
                    <div>
                        <span data-purecounter-end="300">300</span>
                        <p>Horas otimizadas</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-people color-pink flex-shrink-0" style="color: #bb0852;"></i>
                    <div>
                        <span data-purecounter-end="3">3</span>
                        <p>Instituições atendidas</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

        </div>

    </div>

</section>
<!-- /Stats Section -->

<!-- Services Section -->
<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Soluções</h2>
        <p>Como o SIGETI otimiza o atendimento técnico<br></p>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="row gy-4">

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item item-cyan position-relative">
                    <i class="bi bi-ticket-detailed icon"></i>
                    <h3>Abertura de Chamados</h3>
                    <p>Permita que setores registrem solicitações de suporte técnico de forma simples, rápida e
                        organizada.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item item-orange position-relative">
                    <i class="bi bi-kanban icon"></i>
                    <h3>Gestão de Atendimentos</h3>
                    <p>Organize e acompanhe chamados por status, prioridade e responsável, garantindo mais controle
                        no fluxo de atendimento.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item item-teal position-relative">
                    <i class="bi bi-people icon"></i>
                    <h3>Atendimento por Setores</h3>
                    <p>Gerencie solicitações de diferentes secretarias, escolas ou departamentos em um único sistema
                        centralizado.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="service-item item-red position-relative">
                    <i class="bi bi-clock-history icon"></i>
                    <h3>Histórico de Chamados</h3>
                    <p>Tenha acesso completo ao histórico de atendimentos, facilitando auditorias e acompanhamento
                        de demandas.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="service-item item-indigo position-relative">
                    <i class="bi bi-bar-chart icon"></i>
                    <h3>Relatórios e Indicadores</h3>
                    <p>Gere relatórios estratégicos sobre tempo de atendimento, volume de chamados e desempenho da
                        equipe de TI.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="service-item item-pink position-relative">
                    <i class="bi bi-shield-lock icon"></i>
                    <h3>Controle de Acesso</h3>
                    <p>Defina permissões por usuário ou setor, garantindo segurança e organização das
                        informações.</p>
                </div>
            </div>

        </div>
    </div>

</section>
<!-- /Services Section -->

<!-- Pricing Section -->
<section id="pricing" class="pricing section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Planos</h2>
        <p>Escolha o plano ideal para sua instituição<br></p>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="pricing-tem">
                    <h3 style="color: #20c997;">Plano Básico</h3>
                    <div class="price">Sob consulta</div>
                    <div class="icon">
                        <i class="bi bi-box" style="color: #20c997;"></i>
                    </div>
                    <ul>
                        <li>Abertura de chamados</li>
                        <li>Controle básico de atendimentos</li>
                        <li>Cadastro de usuários</li>
                        <li>Histórico de chamados</li>
                        <li class="na">Relatórios avançados</li>
                    </ul>
                    <a href="" class="btn-buy">Solicitar contato</a>
                </div>
            </div><!-- End Pricing Item -->

            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="pricing-tem">
                    <span class="featured">Melhor</span>
                    <h3 style="color: #0dcaf0;">Plano Profissional</h3>
                    <div class="price">Sob consulta</div>
                    <div class="icon">
                        <i class="bi bi-send" style="color: #0dcaf0;"></i>
                    </div>
                    <ul>
                        <li>Tudo do plano básico</li>
                        <li>Gestão por setores</li>
                        <li>Relatórios completos</li>
                        <li>Prioridade de chamados</li>
                        <li>Painel de acompanhamento</li>
                    </ul>
                    <a href="" class="btn-buy">Contratar agora</a>
                </div>
            </div><!-- End Pricing Item -->

            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="pricing-tem">
                    <h3 style="color: #0d6efd;">Plano Corporativo</h3>
                    <div class="price">Sob consulta</div>
                    <div class="icon">
                        <i class="bi bi-airplane" style="color: #fd7e14;"></i>
                    </div>
                    <ul>
                        <li>Tudo do plano profissional</li>
                        <li>Múltiplas secretarias/unidades</li>
                        <li>Relatórios personalizados</li>
                        <li>Suporte prioritário</li>
                        <li>Implantação assistida</li>
                    </ul>
                    <a href="#" class="btn-buy">Falar com especialista</a>
                </div>
            </div><!-- End Pricing Item -->

        </div><!-- End pricing row -->

    </div>

</section>
<!-- /Pricing Section -->

<!-- Faq Section -->
<section id="faq" class="faq section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Perguntas Frequentes</h2>
        <p>Tire suas dúvidas sobre o SIGETI</p>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="faq-container">

                    <div class="faq-item faq-active">
                        <h3>O que é o SIGETI?</h3>
                        <div class="faq-content">
                            <p>O SIGETI é um sistema de gestão de chamados voltado para equipes de TI, permitindo
                                organizar, acompanhar e otimizar atendimentos técnicos em instituições e órgãos
                                públicos.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                    <div class="faq-item">
                        <h3>O sistema pode ser utilizado por prefeituras?</h3>
                        <div class="faq-content">
                            <p>Sim. O SIGETI foi projetado para atender prefeituras e instituições, permitindo o
                                gerenciamento de chamados entre diferentes secretarias e setores.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                    <div class="faq-item">
                        <h3>É possível gerenciar vários setores no mesmo sistema?</h3>
                        <div class="faq-content">
                            <p>Sim. O sistema permite cadastrar múltiplos setores ou unidades, centralizando todos
                                os chamados em um único ambiente organizado.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="faq-container">

                    <div class="faq-item">
                        <h3>Como funciona o suporte técnico?</h3>
                        <div class="faq-content">
                            <p>Oferecemos suporte técnico para auxiliar na implantação e uso do sistema, garantindo
                                que sua equipe utilize todas as funcionalidades de forma eficiente.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                    <div class="faq-item">
                        <h3>O sistema é seguro?</h3>
                        <div class="faq-content">
                            <p>Sim. O SIGETI possui controle de acesso por usuários e níveis de permissão,
                                garantindo a segurança das informações e dos chamados registrados.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                    <div class="faq-item">
                        <h3>Como contratar o SIGETI?</h3>
                        <div class="faq-content">
                            <p>Basta entrar em contato através do formulário ou botão de atendimento. Nossa equipe
                                irá entender sua necessidade e apresentar a melhor solução.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                </div>
            </div>

        </div>
    </div>

</section>
<!-- /Faq Section -->

<!-- Team Section -->
<section id="team" class="team section">

    <!-- Section Title -->
    <section id="team" class="team section">

        <div class="container section-title" data-aos="fade-up">
            <h2>Equipe</h2>
            <p>Desenvolvedores do SIGETI</p>
        </div>

        <div class="container">

            <div class="row gy-4 justify-content-center">



                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="<?= assets_flex_start('/assets/img/team/jp.jpeg') ?>" class="img-fluid"
                                 alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-whatsapp"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>João Pedro</h4>
                            <span>Desenvolvedor</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="<?= assets_flex_start('/assets/img/team/nayra.jpeg') ?>" class="img-fluid"
                                 alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-whatsapp"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>Nayra Geovana</h4>
                            <span>Desenvolvedora</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="<?= assets_flex_start('/assets/img/team/elcio.jpeg') ?>" class="img-fluid"
                                 alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-whatsapp"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>Elcio Reis</h4>
                            <span>Desenvolvedor</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row gy-4 justify-content-center mt-4">



                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="<?= assets_flex_start('/assets/img/team/francisco.jpeg') ?>" class="img-fluid"
                                 alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-whatsapp"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>Francisco Kassio</h4>
                            <span>Desenvolvedor</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="<?= assets_flex_start('/assets/img/team/nayla.jpeg') ?>" class="img-fluid"
                                 alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-whatsapp"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>Nayla Gabriela</h4>
                            <span>Desenvolvedora</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="<?= assets_flex_start('/assets/img/team/ezequiel.jpeg') ?>" class="img-fluid"
                                 alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-whatsapp"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>Ezequiel Viana</h4>
                            <span>Desenvolvedor</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>
    <!-- End Section Title -->

</section>
<!-- /Team Section -->

<!-- Contact Section -->
<section id="contact" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Contato</h2>
        <p>Fale com a equipe do SIGETI</p>
    </div><!-- End Section Title -->

    <div class="container" style="margin-bottom: 100px" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

            <div class="col-lg-6">

                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="info-item" data-aos="fade" data-aos-delay="200">
                            <i class="bi bi-geo-alt"></i>
                            <h3>Localização</h3>
                            <p>Caxias - MA</p>
                            <p>Brasil</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item" data-aos="fade" data-aos-delay="300">
                            <i class="bi bi-telephone"></i>
                            <h3>Telefone</h3>
                            <p>(98) 9 9999-9999</p>
                            <p>(98) 9 8888-8888</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item" data-aos="fade" data-aos-delay="400">
                            <i class="bi bi-envelope"></i>
                            <h3>Email</h3>
                            <p>contato@sigeti.com.br</p>
                            <p>suporte@sigeti.com.br</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item" data-aos="fade" data-aos-delay="500">
                            <i class="bi bi-clock"></i>
                            <h3>Atendimento</h3>
                            <p>Segunda a Sexta</p>
                            <p>08:00 às 18:00</p>
                        </div>
                    </div><!-- End Info Item -->

                </div>

            </div>

            <div class="col-lg-6">
                <form action="" method="post" class="php-email-form" data-aos="fade-up"
                      data-aos-delay="200">
                    <div class="row gy-4">

                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Seu nome" required="">
                        </div>

                        <div class="col-md-6 ">
                            <input type="email" class="form-control" name="email" placeholder="Seu email"
                                   required="">
                        </div>

                        <div class="col-12">
                            <input type="text" class="form-control" name="subject" placeholder="Assunto"
                                   required="">
                        </div>

                        <div class="col-12">
                            <textarea class="form-control" name="message" rows="6"
                                      placeholder="Descreva sua necessidade ou dúvida"
                                      required=""></textarea>
                        </div>

                        <div class="col-12 text-center">
                            <div class="loading">Enviando...</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Mensagem enviada com sucesso! Em breve entraremos em
                                contato.
                            </div>

                            <button type="submit">Enviar Mensagem</button>
                        </div>

                    </div>
                </form>
            </div><!-- End Contact Form -->

        </div>

    </div>

</section>
<!-- /Contact Section -->