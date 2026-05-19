<?= $this->layout("app", [
        "title" => $title
]) ?>

<!-- Hero -->
<section id="hero" class="hero section">

    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-justify">
                <h1 data-aos="fade-up">Gerencie chamados e solicitações de qualquer setor em um só lugar.</h1>
                <p data-aos="fade-up" data-aos-delay="100">O SIGETI é um sistema web completo para abertura,
                    acompanhamento e resolução de chamados e solicitações internas. Organizado, rastreável e acessível
                    de qualquer dispositivo — para qualquer organização que precise de controle real sobre seus
                    atendimentos.</p>
                <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                    <a href="#about" class="btn-get-started">Começar agora<i class="bi bi-arrow-right"></i></a>
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
<!-- /Hero -->

<!-- Sobre -->
<section id="about" class="about section">

    <div class="container" data-aos="fade-up">
        <div class="row gx-0">

            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <div class="content text-justify">
                    <h3>Por que o SIGETI existe?</h3>
                    <h2>Um sistema de chamados feito para qualquer organização, de qualquer ramo.</h2>
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
<!-- /About -->

<!-- Stats -->
<section id="stats" class="stats section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

            <div class="col-lg-3 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-headset color-blue flex-shrink-0"></i>
                    <div>
                        <span data-purecounter-end="120">+1500</span>
                        <p>Chamados gerenciados</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-people color-orange flex-shrink-0" style="color: #ee6c20;"></i>
                    <div>
                        <span data-purecounter-end="45">+80</span>
                        <p>Usuários atendidos</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-house color-green flex-shrink-0" style="color: #15be56;"></i>
                    <div>
                        <span data-purecounter-end="300">+30</span>
                        <p>Organizações atendidas</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-window-desktop color-pink flex-shrink-0" style="color: #bb0852;"></i>
                    <div>
                        <span data-purecounter-end="3">+300</span>
                        <p>Setores atendidos</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

        </div>

    </div>

</section>
<!-- /Stats -->

<!-- Services -->
<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Soluções</h2>
        <p>O que o SIGETI entrega para a sua organização<br></p>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="row gy-4">

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item item-cyan position-relative">
                    <i class="bi bi-ticket-detailed icon"></i>
                    <h3>Abertura de Chamados</h3>
                    <p>Qualquer colaborador registra uma solicitação de forma simples e rápida — sem mensagens
                        informais, sem risco de perda. Tudo documentado e rastreável desde o primeiro momento.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item item-orange position-relative">
                    <i class="bi bi-kanban icon"></i>
                    <h3>Gestão de Atendimentos</h3>
                    <p>Organize e acompanhe chamados por status, prioridade e responsável. Tenha controle total sobre o
                        fluxo de atendimento e saiba exatamente o que está pendente, em andamento ou resolvido.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item item-teal position-relative">
                    <i class="bi bi-people icon"></i>
                    <h3>Atendimento por Setores</h3>
                    <p>Gerencie solicitações de diferentes setores, departamentos ou unidades em um único sistema
                        centralizado. Cada área com sua visão, tudo integrado em um só lugar.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="service-item item-red position-relative">
                    <i class="bi bi-clock-history icon"></i>
                    <h3>Histórico de Chamados</h3>
                    <p>Acesse o histórico completo de todas as solicitações — quem abriu, quem atendeu, quanto tempo
                        levou e como foi resolvido. Informação disponível sempre que precisar.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="service-item item-indigo position-relative">
                    <i class="bi bi-bar-chart icon"></i>
                    <h3>Relatórios e Indicadores</h3>
                    <p>Acompanhe volume de chamados, tempo médio de atendimento e desempenho por setor. Dados reais para
                        decisões mais precisas e gestão mais eficiente.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="service-item item-pink position-relative">
                    <i class="bi bi-shield-lock icon"></i>
                    <h3>Controle de Acesso</h3>
                    <p>Defina perfis de acesso por função — solicitante, atendente ou administrador. Cada usuário acessa
                        apenas o que precisa, garantindo segurança e organização das informações.</p>
                </div>
            </div>

        </div>
    </div>

</section>
<!-- /Services -->

<!-- Pricing Section -->
<section id="pricing" class="pricing section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Planos flexíveis para cada tipo de organização</h2>
        <p>Do essencial ao corporativo — encontre o plano certo para o tamanho e a necessidade da sua operação.<br></p>
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
                        <li>Múltiplos setores</li>
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
                            <p>O SIGETI é um sistema web de gestão de chamados e solicitações internas para qualquer
                                tipo de organização. Com ele, colaboradores abrem solicitações, responsáveis gerenciam
                                os atendimentos e gestores acompanham tudo em tempo real — de qualquer dispositivo com
                                internet.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                    <div class="faq-item">
                        <h3>Quais tipos de organização podem usar o SIGETI?</h3>
                        <div class="faq-content">
                            <p>Qualquer organização que precise gerenciar solicitações internas de forma organizada e
                                rastreável. Empresas de qualquer ramo, escolas, clínicas, construtoras, prefeituras,
                                faculdades, secretarias — o SIGETI foi desenvolvido para ser flexível o suficiente para
                                atender contextos diferentes.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                    <div class="faq-item">
                        <h3>É possível gerenciar vários setores no mesmo sistema?</h3>
                        <div class="faq-content">
                            <p>Sim. O SIGETI permite cadastrar múltiplos setores, departamentos ou unidades,
                                centralizando todas as solicitações em um único ambiente. Cada setor tem sua visão e os
                                gestores acompanham tudo consolidado.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="faq-container">

                    <div class="faq-item">
                        <h3>Como funciona o atendimento dentro do sistema?</h3>
                        <div class="faq-content">
                            <p>O colaborador abre a solicitação descrevendo o problema ou demanda. O responsável pelo
                                atendimento recebe, assume, pode comentar e atualiza o status conforme avança. O
                                solicitante acompanha tudo em tempo real até o encerramento — com registro completo no
                                histórico.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                    <div class="faq-item">
                        <h3>O sistema é seguro?</h3>
                        <div class="faq-content">
                            <p>Sim. O SIGETI possui controle de acesso com perfis e níveis de permissão definidos por
                                função. Cada usuário acessa apenas o que precisa, garantindo a segurança e a integridade
                                das informações.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>

                    <div class="faq-item">
                        <h3>O SIGETI pode ser customizado para a minha organização?</h3>
                        <div class="faq-content">
                            <p>Sim. O SIGETI foi desenvolvido com uma arquitetura flexível que permite customização de
                                fluxos, perfis, categorias e departamentos conforme a necessidade de cada organização.
                                Entre em contato e nossa equipe vai entender o seu contexto para apresentar a melhor
                                solução.</p>
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
            <p>Conheça quem construiu o SIGETI</p>
        </div>

        <div class="container">

            <div class="row gy-4 justify-content-center">

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
                            <img src="<?= assets_flex_start('/assets/img/team/elcio.jpeg') ?>" class="img-fluid"
                                 alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-whatsapp"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>Élcio Reis</h4>
                            <span>Desenvolvedor</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row gy-4 justify-content-center mt-4">

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
                            <h4>Náyla Gabrielle</h4>
                            <span>Desenvolvedora</span>
                        </div>
                    </div>
                </div>

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
                            <h4>Kássio Filho</h4>
                            <span>Desenvolvedor</span>
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
        <p>A sua organização precisa de um sistema de chamados profissional? Fale com a equipe do SIGETI.</p>
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
                            <div class="sent-message">Mensagem recebida! Nossa equipe entrará em contato em até 1 dia
                                útil.
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