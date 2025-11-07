<?php 
require_once 'config.php';

$page_title = 'Informações Técnicas - Decibéis Eletrônica';
include 'includes/header.php'; 
?>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="text-white mb-3">Informações Técnicas</h1>
                <p class="text-white-50 lead">Guia completo sobre equipamentos de áudio profissional</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Mesas de Som</h2>
                <p class="text-white-50">Especificações técnicas e características principais</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="tech-card">
                    <div class="tech-header"><i class="fas fa-sliders-h"></i><h4>Mesas Analógicas</h4></div>
                    <div class="tech-content">
                        <h5 class="text-warning">Características Técnicas:</h5>
                        <ul class="tech-list">
                            <li><strong>Canais:</strong> 8 a 32 canais de entrada</li>
                            <li><strong>Pré-amplificadores:</strong> Ganho de 60dB</li>
                            <li><strong>EQ:</strong> 3 bandas com sweep médio</li>
                            <li><strong>Auxiliares:</strong> 2 a 6 envios auxiliares</li>
                            <li><strong>Phantom Power:</strong> +48V individual ou global</li>
                        </ul>
                        <h5 class="text-warning mt-4">Aplicações:</h5>
                        <ul class="tech-list">
                            <li>Gravação em estúdio</li>
                            <li>Apresentações ao vivo</li>
                            <li>Sistemas de som fixos</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tech-card">
                    <div class="tech-header"><i class="fas fa-microchip"></i><h4>Mesas Digitais</h4></div>
                    <div class="tech-content">
                        <h5 class="text-warning">Características Técnicas:</h5>
                        <ul class="tech-list">
                            <li><strong>Canais:</strong> 16 a 64 canais virtuais</li>
                            <li><strong>Conversão A/D:</strong> 24-bit/96kHz</li>
                            <li><strong>Processamento:</strong> DSP integrado</li>
                            <li><strong>Conectividade:</strong> USB, Ethernet, MIDI</li>
                            <li><strong>Efeitos:</strong> Reverb, compressor, gate</li>
                        </ul>
                        <h5 class="text-warning mt-4">Vantagens:</h5>
                        <ul class="tech-list">
                            <li>Flexibilidade de roteamento</li>
                            <li>Processamento integrado</li>
                            <li>Recall de configurações</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Amplificadores</h2>
                <p class="text-white-50">Potência e qualidade para seus sistemas</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="tech-card">
                    <div class="tech-header"><i class="fas fa-bolt"></i><h4>Classe A/B</h4></div>
                    <div class="tech-content">
                        <ul class="tech-list">
                            <li><strong>Potência:</strong> 200W - 2000W RMS</li>
                            <li><strong>THD:</strong> &lt; 0.1% @ 1kHz</li>
                            <li><strong>Impedância:</strong> 2, 4, 8 ohms</li>
                            <li><strong>Proteções:</strong> Curto, temperatura</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tech-card">
                    <div class="tech-header"><i class="fas fa-microchip"></i><h4>Classe D</h4></div>
                    <div class="tech-content">
                        <ul class="tech-list">
                            <li><strong>Potência:</strong> 500W - 5000W RMS</li>
                            <li><strong>Eficiência:</strong> &gt; 90%</li>
                            <li><strong>Peso:</strong> Ultracompacto</li>
                            <li><strong>Vantagens:</strong> Baixo consumo</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tech-card">
                    <div class="tech-header"><i class="fas fa-cog"></i><h4>Amplificadores DSP</h4></div>
                    <div class="tech-content">
                        <ul class="tech-list">
                            <li><strong>Processamento:</strong> Digital integrado</li>
                            <li><strong>Filtros:</strong> Crossover, EQ, limitador</li>
                            <li><strong>Controle:</strong> Software dedicado</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Caixas Acústicas</h2>
                <p class="text-white-50">Reprodução precisa e potente</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="tech-card">
                    <div class="tech-header"><i class="fas fa-volume-up"></i><h4>Caixas Passivas</h4></div>
                    <div class="tech-content">
                        <ul class="tech-list">
                            <li><strong>Potência:</strong> 200W - 1000W RMS</li>
                            <li><strong>Impedância:</strong> 8 ohms</li>
                            <li><strong>SPL:</strong> 120dB - 135dB</li>
                            <li><strong>Vantagens:</strong> Flexibilidade</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tech-card">
                    <div class="tech-header"><i class="fas fa-broadcast-tower"></i><h4>Caixas Ativas</h4></div>
                    <div class="tech-content">
                        <ul class="tech-list">
                            <li><strong>Amplificação:</strong> Integrada</li>
                            <li><strong>Conectividade:</strong> XLR, P10</li>
                            <li><strong>Proteção:</strong> Limitador</li>
                            <li><strong>Vantagens:</strong> Praticidade</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tech-card">
                    <div class="tech-header"><i class="fas fa-compress-arrows-alt"></i><h4>Subwoofers</h4></div>
                    <div class="tech-content">
                        <ul class="tech-list">
                            <li><strong>Resposta:</strong> 30Hz - 150Hz</li>
                            <li><strong>Potência:</strong> 500W - 2000W</li>
                            <li><strong>Configuração:</strong> 12", 15", 18"</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Guia de Manutenção</h2>
                <p class="text-white-50">Mantenha seus equipamentos sempre em perfeito funcionamento</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="maintenance-card">
                    <div class="maintenance-icon"><i class="fas fa-calendar-check"></i></div>
                    <h4>Manutenção Preventiva</h4>
                    <ul class="maintenance-list">
                        <li>Limpeza mensal dos equipamentos</li>
                        <li>Verificação de cabos e conectores</li>
                        <li>Teste de funcionamento</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="maintenance-card">
                    <div class="maintenance-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <h4>Problemas Comuns</h4>
                    <ul class="maintenance-list">
                        <li>Ruído em canais (oxidação)</li>
                        <li>Faders com mau contato</li>
                        <li>Superaquecimento</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="maintenance-card">
                    <div class="maintenance-icon"><i class="fas fa-shield-alt"></i></div>
                    <h4>Cuidados Especiais</h4>
                    <ul class="maintenance-list">
                        <li>Transporte adequado</li>
                        <li>Armazenamento em local seco</li>
                        <li>Uso de estabilizadores</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="text-white mb-3">Precisa de Ajuda Técnica?</h2>
                <p class="text-white-50 mb-4">
                    Nossa equipe técnica está pronta para ajudar você com qualquer dúvida sobre equipamentos de áudio profissional.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="contact.php" class="btn btn-warning btn-lg">
                    <i class="fas fa-tools me-2"></i>Solicitar Suporte
                </a>
            </div>
        </div>
    </div>
</section>

<?php 
include 'includes/footer.php'; 
?>