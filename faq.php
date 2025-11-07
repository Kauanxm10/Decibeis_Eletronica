<?php 
require_once 'config.php';

// Busca os FAQs no banco de dados que estão ativos
$faqs = $db->fetchAll("SELECT * FROM faq WHERE is_active = TRUE ORDER BY order_position ASC");

$page_title = 'FAQ - Dúvidas Frequentes sobre Reparo e Manutenção';
$page_description = 'Encontre respostas rápidas para as dúvidas mais comuns sobre o processo de reparo, prazos, orçamentos e marcas atendidas pela Decibéis Eletrônica.';
$page_keywords = 'dúvidas reparo áudio, quanto tempo conserto, orçamento gratuito, reparo mesa de som, perguntas frequentes';
// =======
include 'includes/header.php'; 
?>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="text-white mb-3">Perguntas Frequentes</h1>
                <p class="text-white-50 lead">Respostas para as dúvidas mais comuns sobre nossos serviços</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="faq-intro mb-5">
                    <h2 class="text-white mb-3">Soluções para Seus Problemas</h2>
                    <p class="text-white-50">
                        Na Decibéis Eletrônica, temos experiência em resolver uma ampla gama de problemas em equipamentos de áudio profissional. 
                        Confira abaixo as perguntas mais frequentes e suas respostas. Se não encontrar o que procura, 
                        <a href="contact.php" class="text-warning">entre em contato conosco</a>.
                    </p>
                </div>
                
                <?php if (!empty($faqs)): ?>
                <div class="accordion" id="faqAccordion">
                    <?php foreach ($faqs as $index => $faq): ?>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="heading<?php echo $faq['id']; ?>">
                            <button class="accordion-button <?php echo ($index > 0) ? 'collapsed' : ''; ?>" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapse<?php echo $faq['id']; ?>" 
                                    aria-expanded="<?php echo ($index == 0) ? 'true' : 'false'; ?>" 
                                    aria-controls="collapse<?php echo $faq['id']; ?>">
                                <i class="fas fa-question-circle me-3 text-warning"></i>
                                <?php echo htmlspecialchars($faq['question']); ?>
                            </button>
                        </h3>
                        <div id="collapse<?php echo $faq['id']; ?>" 
                             class="accordion-collapse collapse <?php echo ($index == 0) ? 'show' : ''; ?>" 
                             aria-labelledby="heading<?php echo $faq['id']; ?>" 
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <div class="faq-answer">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                    <p class="text-center text-white">Nenhuma pergunta frequente encontrada no momento.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Principais Problemas que Resolvemos</h2>
                <p class="text-white-50">Nossa expertise cobre uma ampla gama de equipamentos e defeitos</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="problem-card">
                    <div class="problem-icon"><i class="fas fa-sliders-h"></i></div>
                    <h4>Mesas de Som</h4>
                    <ul class="problem-list">
                        <li>Faders com mau contato</li>
                        <li>Canais com ruído</li>
                        <li>Phantom power intermitente</li>
                        <li>EQ não funciona</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="problem-card">
                    <div class="problem-icon"><i class="fas fa-volume-up"></i></div>
                    <h4>Amplificadores</h4>
                    <ul class="problem-list">
                        <li>Não liga / Proteção ativada</li>
                        <li>Áudio distorcido</li>
                        <li>Superaquecimento</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="problem-card">
                    <div class="problem-icon"><i class="fas fa-microphone"></i></div>
                    <h4>Microfones</h4>
                    <ul class="problem-list">
                        <li>Sem áudio / Ruído excessivo</li>
                        <li>Baixa sensibilidade</li>
                        <li>Cápsula danificada</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-white mb-3">Processo de Atendimento</h2>
                <p class="text-white-50">Como funciona nosso processo de reparo</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Diagnóstico</h4>
                        <p>Avaliação completa do equipamento para identificar o problema.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="process-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Orçamento</h4>
                        <p>Apresentação detalhada dos custos e prazo de execução.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="process-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Reparo</h4>
                        <p>Execução do serviço com peças originais e técnicas especializadas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="process-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h4>Entrega</h4>
                        <p>Teste final e entrega com garantia do serviço realizado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="text-white mb-3">Ainda Tem Dúvidas?</h2>
                <p class="text-white-50 mb-4">
                    Nossa equipe técnica está pronta para ajudar você com qualquer dúvida sobre equipamentos de áudio profissional.
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