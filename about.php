<?php
// Inclui o arquivo de configuração e conexão com o banco de dados.
require_once 'config.php';

// =========================================================================
// CORREÇÃO ESSENCIAL: BUSCA E CONVERTE OS DADOS DE CHAVE/VALOR (info_key => info_value)
// Esta correção garante que o nome da empresa e outras infos funcionem.
// =========================================================================
$allCompanyData = $db->fetchAll("SELECT info_key, info_value FROM company_info");

$companyInfo = [];
if (!empty($allCompanyData)) {
    // Transforma o array de linhas em um array simples (chave => valor)
    foreach ($allCompanyData as $item) {
        $companyInfo[$item['info_key']] = $item['info_value'];
    }
}
// =========================================================================

$page_title = 'Sobre a Decibéis Eletrônica | 25 Anos de Expertise em Áudio';
$page_description = 'Conheça nossa história e compromisso com a excelência. Mais de 25 anos de experiência e 9000+ equipamentos reparados. Qualidade e garantia no seu equipamento.';
$page_keywords = 'história Decibéis Eletrônica, missão, valores, técnicos certificados, garantia estendida';

include 'includes/header.php';
?>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="text-white mb-3">Sobre a <?php echo htmlspecialchars($companyInfo['company_name'] ?? 'Decibéis Eletrônica'); ?></h1>
                <p class="text-white-50 lead">Especializado em manutenção de equipamentos de áudio profissional há mais de 20 anos</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row align-items-center">
            
           <div class="col-lg-6">
                <div id="aboutCarousel" class="carousel slide" data-bs-ride="carousel">
                    
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>

                    <div class="carousel-inner rounded-3 shadow-lg">
                        
                        <div class="carousel-item active">
                            <img src="assets/img/about-image-1.jpg" 
                                alt="Oficina da Decibéis Eletrônica" 
                                class="d-block w-100" style="height: 400px; object-fit: cover;">
                        </div>
                        
                        <div class="carousel-item">
                            <img src="assets/img/about-image-2.jpg" 
                                alt="Equipamentos de Áudio" 
                                class="d-block w-100" style="height: 400px; object-fit: cover;">
                        </div>
                        
                        <div class="carousel-item">
                            <img src="assets/img/about-image-3.jpg" 
                                alt="Estúdio de Gravação" 
                                class="d-block w-100" style="height: 400px; object-fit: cover;">
                        </div>
                    </div>
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                    </button>
                </div>
            </div>
            
            <div class="col-lg-6">
                <h2 class="text-white mb-4">Nossa História</h2>
                <p class="text-white-50 mb-4">
                    A Decibéis Eletrônica, nasceu da junção entre a paixão pela eletrônica, o desejo de prestar um atendimento diferenciado e a admiração pela música.
 Seu fundador Éverson Cardoso iniciou seu aprendizado na área com aproximadamente 13 anos, sendo aprendiz e montando pequenos projetos de livros da época, com 14 anos começou a trabalhar em assistência técnica, onde aprofunda seus conhecimentos e aprendizados, mas também identifica seu desacordo com o atendimento mecanizado e não muito claro aos clientes.

                </p>
                <p class="text-white-50 mb-4">
                   Em novembro de 2000, ao retornar para Lages, abre a Decibéis Eletrônica, com atendimento em todas as linhas de aparelhos eletrônicos, de tudo mesmo.
                    Mas seu intuito era conseguir unir suas paixões.
                    Hoje, este sonho foi alcançado, prestando serviço de manutenção em equipamentos de áudio profissional, com seriedade, ética, transparência, qualidade e muito respeito aos clientes.
                    Posto autorizado das principais marcas do gênero no mercado nacional e importados, parceria com as lojas do ramo na região.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Nosso Compromisso</h2>
                <p class="text-white-50">Excelência e satisfação do cliente como pilares</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="mission-card">
                    <div class="mission-icon"><i class="fas fa-bullseye"></i></div>
                    <h4 class="text-warning">Missão</h4>
                    <p class="text-white-50">
                        Prestar serviços de manutenção com excelência em equipamentos de áudio profissional, garantindo alto desempenho, confiabilidade e satisfação aos nossos clientes, com agilidade, responsabilidade técnica e compromisso com a qualidade.

                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mission-card">
                    <div class="mission-icon"><i class="fas fa-eye"></i></div>
                    <h4 class="text-warning">Visão</h4>
                    <p class="text-white-50">
                        Ser referência regional em assistência técnica de equipamentos de áudio profissional, conhecida pela qualidade dos serviços, inovação contínua e relacionamento de confiança com clientes e parceiros.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mission-card">
                    <div class="mission-icon"><i class="fas fa-heart"></i></div>
                    <h4 class="text-warning">Valores</h4>
                    <p class="text-white-50">
                        - Compromisso com a qualidade <br>
                            - ética e transparência <br>
                            - agilidade e eficiência nos atendimentos<br>
                            - respeito ao cliente e ao meio ambiente<br>
                            - atualização técnica constante<br>
                            - valorização da experiência e só conhecimento técnico acumulado ao longo dos anos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Nossa Experiência</h2>
                <p class="text-white-50">Números que comprovam nossa excelência</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-number">25+</div>
                    <div class="stat-label">Anos de Experiência</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-number">9000+</div>
                    <div class="stat-label">Equipamentos Reparados</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-number">4000+</div>
                    <div class="stat-label">Clientes cadastrados</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Satisfação dos Clientes</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Nossos Diferenciais</h2>
                <p class="text-white-50">Por que escolher a Decibéis Eletrônica?</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-certificate"></i></div>
                    <h5>Técnicos Certificados</h5>
                    <p class="text-white-50">Equipe formada por profissionais certificados pelas principais marcas do mercado mundial.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-tools"></i></div>
                    <h5>Equipamentos Modernos</h5>
                    <p class="text-white-50">Utilizamos equipamentos de última geração para diagnóstico e reparo preciso.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h5>Garantia Estendida</h5>
                    <p class="text-white-50">Todos os nossos serviços incluem garantia estendida para sua total tranquilidade.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-clock"></i></div>
                    <h5>Agilidade</h5>
                    <p class="text-white-50">Processos otimizados para entrega rápida sem comprometer a qualidade.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-handshake"></i></div>
                    <h5>Atendimento Personalizado</h5>
                    <p class="text-white-50">Cada cliente recebe atendimento individual e soluções customizadas.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-dollar-sign"></i></div>
                    <h5>Preços Justos</h5>
                    <p class="text-white-50">Orçamentos transparentes e competitivos, sem custos ocultos.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="text-white mb-3">Pronto para conhecer nossos serviços?</h2>
                <p class="text-white-50 mb-4">
                    Entre em contato conosco e descubra como podemos ajudar você a alcançar a excelência em áudio profissional.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="contact.php" class="btn btn-warning btn-lg">
                    <i class="fas fa-phone me-2"></i>Fale Conosco
                </a>
            </div>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>