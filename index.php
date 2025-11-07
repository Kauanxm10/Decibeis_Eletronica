<?php
// Inclui o arquivo de configuração e conexão com o banco de dados.
require_once 'config.php';

// Busca as 5 notícias mais recentes no banco de dados para o carrossel.
$news_items = $db->fetchAll("SELECT * FROM news_item ORDER BY published_date DESC LIMIT 5");

// =========================================================================
// CORREÇÃO FINAL: BUSCA E CONVERTE OS DADOS DE CHAVE/VALOR (info_key => info_value)
// =========================================================================
$allCompanyData = $db->fetchAll("SELECT info_key, info_value FROM company_info");

$companyInfo = [];
if (!empty($allCompanyData)) {
    // Transforma o array de linhas em um array simples (chave => valor)
    foreach ($allCompanyData as $item) {
        $companyInfo[$item['info_key']] = $item['info_value'];
    }
}
// NOTA: Agora, $companyInfo deve ter chaves como ['address'], ['phone'], etc.
// =========================================================================
// =======================================================
// NOVAS VARIÁVEIS DE SEO E TÍTULO
// Estas variáveis serão usadas pelo includes/header.php
// =======================================================
$page_title = 'Assistência Técnica de Áudio Profissional | Decibéis Eletrônica';
$page_description = 'Especializado na manutenção em equipamentos de áudio profissional. Soluções para estúdios, empresas de sonorização, músicos profissionais e amadores. Apreciadores da música em geral.';
$page_keywords = 'assistência técnica áudio, reparo mesas de som, conserto amplificadores, Decibéis Eletrônica, manutenção áudio profissional, periféricos som';
// =======================================================

// Inclui o header.
// A busca foi feita acima, garantindo que $companyInfo esteja disponível aqui e no header/footer.
include 'includes/header.php';
?>

<!-- CORREÇÃO APLICADA: Removido min-vh-100 para evitar que a altura mínima empurre o conteúdo -->
<section class="hero-section"> 
    <div class="container">
        <div class="row align-items-center" style="min-height: calc(100vh - 100px);"> 
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-white mb-4">
                    <span class="text-warning"><?php echo htmlspecialchars($companyInfo['company_name'] ?? 'Decibéis Eletrônica'); ?></span><br>
                    Assistência Técnica
                </h1>
                <p class="lead text-white-50 mb-4">
                    Especializado na manutenção em equipamentos de áudio profissional. Soluções para estúdios, empresas de sonorização, músicos profissionais e amadores. Apreciadores da música em geral.

                </p>
                <div class="d-flex gap-3">
                    <a href="contact.php" class="btn btn-warning btn-lg">
                        <i class="fas fa-phone me-2"></i>Entre em Contato
                    </a>
                    <a href="about.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle me-2"></i>Saiba Mais
                    </a>
                </div>
            </div>
          <div class="col-lg-6">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4" aria-current="true" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="5" aria-current="true" aria-label="Slide 6"></button>
        </div>

        <div class="carousel-inner rounded-3 shadow-lg">
            
            <div class="carousel-item active">
                <img src="assets/img/hero-image-1.jpg" class="d-block w-100" alt="Equipamento de Áudio 1" style="height: 450px; object-fit: cover;">
            </div>
            
            <div class="carousel-item">
                <img src="assets/img/hero-image-2.jpg" class="d-block w-100" alt="Equipamento de Áudio 2" style="height: 450px; object-fit: cover;">
            </div>
            
            <div class="carousel-item">
                <img src="assets/img/hero-image-3.jpg" class="d-block w-100" alt="Equipamento de Áudio 3" style="height: 450px; object-fit: cover;">
            </div>

            <div class="carousel-item">
                <img src="assets/img/hero-image-4.jpg" class="d-block w-100" alt="Equipamento de Áudio 4" style="height: 450px; object-fit: cover;">
            </div>

            <div class="carousel-item">
                <img src="assets/img/hero-image-5.jpg" class="d-block w-100" alt="Equipamento de Áudio 5" style="height: 450px; object-fit: cover;">
            </div>

            <div class="carousel-item">
                <img src="assets/img/hero-image-6.jpg" class="d-block w-100" alt="Equipamento de Áudio 6" style="height: 450px; object-fit: cover;">
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>
</div>
    </div>
    </div>
</section>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Nossos Serviços</h2>
                <p class="text-white-50">Soluções completas para suas necessidades de áudio profissional</p>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <!-- SERVIÇO 1: Reparo de Equipamentos -->
            <!-- Ajustado para col-lg-6 (50% da largura) -->
            <div class="col-md-6 col-lg-6">
                <div class="service-card h-100">
                    <div class="service-icon"><i class="fas fa-tools"></i></div>
                    <h4>Reparos em Equipamentos de Áudio</h4>
                    <p>Manutenção especializada em mesas de som, amplificadores, caixas e toda linha de periféricos relacionados ao som profissional.</p>
                </div>
            </div>
            <!-- REMOVIDO: Instalação de Estúdios -->
            
            <!-- SERVIÇO 2: Consultoria Técnica -->
            <!-- Ajustado para col-lg-6 (50% da largura) -->
            <div class="col-md-6 col-lg-6">
                <div class="service-card h-100">
                    <div class="service-icon"><i class="fas fa-cog"></i></div>
                    <h4>Reparos em Equipamentos de Efeitos</h4>
                    <p>Manutenção especializada em equipamentos de iluminação, moving Head, Bean, canhões, DMX e máquinas de fumaça.</p>
                </div>
            </div>
            <!-- REMOVIDO: Vendas e Peças -->
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Notícias do Setor</h2>
                <p class="text-white-50">Fique por dentro das novidades em áudio profissional</p>
            </div>
        </div>
        
        <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php if (!empty($news_items)): ?>
                    <?php foreach ($news_items as $index => $news): ?>
                        <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                            <div class="row justify-content-center">
                                <div class="col-md-9 col-lg-7"> <div class="news-card">
                                        
                                        <?php if (!empty($news['image_url'])): ?>
                                            <img src="<?php echo htmlspecialchars($news['image_url']); ?>" 
                                                class="news-image img-fluid rounded shadow-sm mb-4" 
                                                alt="Imagem da notícia: <?php echo htmlspecialchars($news['title']); ?>">
                                        <?php endif; ?>

                                        <h4 class="news-title text-warning mb-3"><?php echo htmlspecialchars($news['title']); ?></h4>
                                        <p class="news-content text-white-50 mb-4">
                                            <?php echo htmlspecialchars(mb_strimwidth($news['content'], 0, 250, "...")); // Aumentei o limite para 250 caracteres ?>
                                        </p>
                                        
                                        <?php if (!empty($news['url'])): ?>
                                            <a href="<?php echo htmlspecialchars($news['url']); ?>" class="btn btn-warning btn-md" target="_blank">
                                                <i class="fas fa-external-link-alt me-2"></i>Leia mais
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-md-7 text-center">
                                <div class="news-card">
                                    <h4 class="news-title text-warning mb-3">Aguardando Notícias</h4>
                                    <p class="news-content text-white-50 mb-3">As últimas notícias do setor de áudio profissional serão exibidas aqui em breve. Adicione-as no painel de admin!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (count($news_items) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Anterior</span></button>
                <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Próximo</span></button>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Lojas Parceiras</h2>
                <p class="text-white-50">Parceiros confiáveis para suas necessidades</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3"><div class="partner-card"><div class="partner-logo"><i class="fas fa-store"></i></div><h5>Music Store</h5><p>Equipamentos e instrumentos musicais</p></div></div>
            <div class="col-md-6 col-lg-3"><div class="partner-card"><div class="partner-logo"><i class="fas fa-headphones"></i></div><h5>Audio Pro</h5><p>Especialista em áudio profissional</p></div></div>
            <div class="col-md-6 col-lg-3"><div class="partner-card"><div class="partner-logo"><i class="fas fa-compact-disc"></i></div><h5>Studio Equipment</h5><p>Equipamentos para estúdios</p></div></div>
            <div class="col-md-6 col-lg-3"><div class="partner-card"><div class="partner-logo"><i class="fas fa-music"></i></div><h5>Sound Solutions</h5><p>Soluções completas em som</p></div></div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Nossa Localização</h2>
                <p class="text-white-50">Venha nos visitar em nossa loja física</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3528.919184059011!2d-50.29451742487674!3d-27.81225837612261!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94e01ec3db014da7%3A0xdce10d4362833742d!2sR.%20Jo%C3%A3o%20Francisco%20Veloso%2C%20120%20-%20S%C3%A3o%20Miguel%2C%20Lages%20-%20SC%2C%2088525-040!5e0!3m2!1spt-BR!2sbr!4v1753119605188!5m2!1spt-BR!2sbr" 
                            width="100%" 
                            height="400" 
                            style="border:0; border-radius: 15px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            title="Localização da <?php echo htmlspecialchars($companyInfo['company_name'] ?? 'Decibéis Eletrônica'); ?>"></iframe>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="location-info">
                    <h4 class="text-warning mb-4">Informações de Contato</h4>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt text-warning me-3"></i>
                        <div>
                            <h6 class="text-white mb-1">Endereço</h6>
                            <p class="text-white-50 mb-3"><?php echo nl2br(htmlspecialchars($companyInfo['address'] ?? 'Não informado')); ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone text-warning me-3"></i>
                        <div>
                            <h6 class="text-white mb-1">Telefone</h6>
                            <p class="text-white-50 mb-3"><?php echo htmlspecialchars($companyInfo['phone'] ?? 'Não informado'); ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock text-warning me-3"></i>
                        <div>
                            <h6 class="text-white mb-1">Horário</h6>
                            <p class="text-white-50 mb-3"><?php echo htmlspecialchars($companyInfo['business_hours'] ?? 'Não informado'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>
