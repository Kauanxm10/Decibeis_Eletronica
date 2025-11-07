<!-- Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5 class="text-warning mb-3">
                    <i class="fas fa-volume-up me-2"></i>Decibéis Eletrônica
                </h5>
                <p class="text-white-50">
                   Especializado na manutenção em equipamentos de áudio profissional. 
                    25 anos de história, buscando sempre aperfeiçoamento para prestar o melhor serviço.
                </p>
                <div class="social-links">
                    <a href="https://www.instagram.com/decibeis_eletronica?utm_source=ig_web_button_share_sheet&igsh=MWJ6YTR4eGk0dXJ5Nw==" class="social-link me-3" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/@decibeiseletronica" class="social-link me-3" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="text-warning mb-3">Navegação</h6>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-white-50 text-decoration-none">Início</a></li>
                    <li><a href="about.php" class="text-white-50 text-decoration-none">Sobre</a></li>
                    <li><a href="technical.php" class="text-white-50 text-decoration-none">Técnico</a></li>
                    <li><a href="contact.php" class="text-white-50 text-decoration-none">Contato</a></li>
                    <li><a href="faq.php" class="text-white-50 text-decoration-none">FAQ</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="text-warning mb-3">Serviços</h6>
                <ul class="list-unstyled">
                    <li class="text-white-50">Manutenção corretiva e preventiva.</li>
                    <li class="text-white-50">Busca e entrega grátis.</li>
                    <li class="text-white-50">Orçamento sem compromisso.</li>
                </ul>
            </div>
            
            <div class="col-lg-3 mb-4">
                <h6 class="text-warning mb-3">Contato</h6>
                    <div class="contact-info-footer">
                        <p class="text-white-50 mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <?php echo nl2br(htmlspecialchars($companyInfo['address'] ?? 'Endereço não informado')); ?>
                        </p>
                        <p class="text-white-50 mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <?php echo htmlspecialchars($companyInfo['phone'] ?? 'Telefone não informado'); ?>
                        </p>
                        <p class="text-white-50 mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:<?php echo htmlspecialchars($companyInfo['email'] ?? ''); ?>" class="text-white-50 text-decoration-none">
                                <?php echo htmlspecialchars($companyInfo['email'] ?? 'Email não informado'); ?>
                            </a>
                        </p>
                        <p class="text-white-50">
                            <i class="fas fa-clock me-2"></i>
                            <?php echo htmlspecialchars($companyInfo['business_hours'] ?? 'Horário não informado'); ?>
                        </p>
                    </div>
            </div>
        </div>
        
        <hr class="border-secondary">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; 2025 Decibéis Eletrônica. Todos os direitos reservados.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">Desenvolvido com tecnologia e paixão por áudio</p>
                <small><a href="admin/login.php" class="text-muted text-decoration-none">Admin</a></small>
            </div>
        </div>
    </div>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>