<?php
// Inicia a sessão no topo para usar mensagens de feedback
session_start();

// Inclui o arquivo de configuração e conexão com o banco
require_once 'config.php';

// =========================================================================
// CORREÇÃO ESSENCIAL: BUSCA E CONVERTE OS DADOS DE CHAVE/VALOR
// =========================================================================
$allCompanyData = $db->fetchAll("SELECT info_key, info_value FROM company_info");

$companyInfo = [];
if (!empty($allCompanyData)) {
    // Transforma o array de linhas em um array simples (chave => valor)
    foreach ($allCompanyData as $item) {
        $companyInfo[$item['info_key']] = $item['info_value'];
    }
}
// NOTA: Agora, $companyInfo está no formato correto para o template: 
// $companyInfo['address'], $companyInfo['phone'], etc.
// =========================================================================


// --- INÍCIO DA LÓGICA DE PROCESSAMENTO DO FORMULÁRIO ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Coletar e Sanitizar Dados
    $name = sanitize($_POST['name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = sanitize($_POST['phone']);
    $message = sanitize($_POST['message']);
    $appointment_date = !empty($_POST['appointment_date']) ? $_POST['appointment_date'] : null;
    $appointment_time = !empty($_POST['appointment_time']) ? $_POST['appointment_time'] : null;
    $file_path = null;

    // 2. Processar Upload do Arquivo
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $file_name = uniqid() . '-' . basename($_FILES['file']['name']);
        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $file_path = $target_file;
        }
    }

    // 3. Salvar no Banco de Dados
    $db->insert('contact_submission', [
        'name' => $name, 'email' => $email, 'phone' => $phone, 'message' => $message,
        'appointment_date' => $appointment_date, 'appointment_time' => $appointment_time, 'file_path' => $file_path
    ]);
    
    // 4. Preparar e Redirecionar para o WhatsApp
    // O código abaixo usa $companyInfo['whatsapp_number'] que agora está disponível!
    $whatsapp_number = $companyInfo['whatsapp_number'] ?? ''; 
    $whatsapp_number = preg_replace('/\D/', '', $whatsapp_number);

    $whatsapp_message = "Olá! Meu nome é {$name}.\n\nMensagem: {$message}\n\nEmail: {$email}\nTelefone: {$phone}";
    if ($appointment_date) $whatsapp_message .= "\nData Sugerida: " . date('d/m/Y', strtotime($appointment_date));
    if ($appointment_time) $whatsapp_message .= "\nHorário Sugerido: {$appointment_time}";
    
    $whatsapp_url = "https://wa.me/{$whatsapp_number}?text=" . urlencode($whatsapp_message);
    redirect($whatsapp_url);
}

// --- LÓGICA PARA EXIBIR A PÁGINA ---

// Busca os horários disponíveis (essa busca já estava correta)
$available_times = $db->fetchAll("SELECT time_slot, description FROM available_time WHERE is_active = TRUE ORDER BY time_slot ASC");

$page_title = 'Fale Conosco | Agende seu Reparo e Solicite um Orçamento';
$page_description = 'Entre em contato com a Decibéis Eletrônica. Agende um horário para diagnóstico, solicite um orçamento e fale diretamente com nossa equipe via WhatsApp.';
$page_keywords = 'contato Decibéis Eletrônica, agendamento reparo, telefone, WhatsApp, orçamento áudio profissional, email';

include 'includes/header.php'; 
?>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="text-white mb-3">Entre em Contato</h1>
                <p class="text-white-50 lead">Estamos aqui para ajudar você com suas necessidades de áudio profissional</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="contact-form-container">
                    <h2 class="text-white mb-4">Envie sua Mensagem</h2>
                    <form action="contact.php" method="POST" enctype="multipart/form-data" class="contact-form">
                        <div class="row g-3">
                            <div class="col-md-6"><label for="name" class="form-label text-white">Nome Completo *</label><input type="text" class="form-control" id="name" name="name" required></div>
                            <div class="col-md-6"><label for="email" class="form-label text-white">E-mail *</label><input type="email" class="form-control" id="email" name="email" required></div>
                            <div class="col-md-6"><label for="phone" class="form-label text-white">Telefone/WhatsApp</label><input type="tel" class="form-control" id="phone" name="phone" placeholder="(11) 99999-9999"></div>
                            <div class="col-md-6"><label for="appointment_date" class="form-label text-white">Data para Atendimento</label><input type="date" class="form-control" id="appointment_date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>"></div>
                            <div class="col-md-6">
                                <label for="appointment_time" class="form-label text-white">Horário Preferido</label>
                                <select class="form-select" id="appointment_time" name="appointment_time">
                                    <option value="">Selecione um horário</option>
                                    <?php foreach ($available_times as $time): ?>
                                        <option value="<?php echo htmlspecialchars($time['time_slot']); ?>"><?php echo htmlspecialchars($time['time_slot']); ?><?php if (!empty($time['description'])) echo ' - ' . htmlspecialchars($time['description']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6"><label for="file" class="form-label text-white">Anexar Arquivo</label><input type="file" class="form-control" id="file" name="file" accept=".jpg,.jpeg,.png,.pdf"><small class="text-white-50">Máx. 16MB</small></div>
                            <div class="col-12"><label for="message" class="form-label text-white">Mensagem *</label><textarea class="form-control" id="message" name="message" rows="5" required placeholder="Descreva seu problema ou necessidade..."></textarea></div>
                            <div class="col-12"><button type="submit" class="btn btn-warning btn-lg"><i class="fab fa-whatsapp me-2"></i>Enviar via WhatsApp</button></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info">
                    <h3 class="text-white mb-4">Informações de Contato</h3>
                    <div class="contact-item mb-4">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="contact-details">
                            <h5 class="text-warning">Endereço</h5>
                            <p class="text-white-50"><?php echo nl2br(htmlspecialchars($companyInfo['address'] ?? '...')); ?></p>
                        </div>
                    </div>
                    <div class="contact-item mb-4">
                        <div class="contact-icon"><i class="fas fa-phone"></i></div>
                        <div class="contact-details">
                            <h5 class="text-warning">Telefone</h5>
                            <p class="text-white-50"><?php echo htmlspecialchars($companyInfo['phone'] ?? '...'); ?></p>
                        </div>
                    </div>
                    <div class="contact-item mb-4">
                        <div class="contact-icon"><i class="fas fa-clock"></i></div>
                        <div class="contact-details">
                            <h5 class="text-warning">Horário</h5>
                            <p class="text-white-50"><?php echo htmlspecialchars($companyInfo['business_hours'] ?? '...'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="text-white mb-3">Nossa Localização</h2>
                <p class="text-white-50">Visite nossa loja física</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3528.919184059011!2d-50.29451742487674!3d-27.81225837612261!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94e01ec3db014da7%3A0xdce10d436283742d!2sR.%20Jo%C3%A3o%20Francisco%20Veloso%2C%20120%20-%20S%C3%A3o%20Miguel%2C%20Lages%20-%20SC%2C%2088525-040!5e0!3m2!1spt-BR!2sbr!4v1753119605188!5m2!1spt-BR!2sbr" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" title="Localização da <?php echo htmlspecialchars($companyInfo['company_name'] ?? ''); ?>"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white mb-3">Horários Disponíveis para Agendamento</h2>
                <p class="text-white-50 mb-4">Escolha o melhor horário para seu atendimento</p>
                <!-- CORREÇÃO APLICADA: justify-content-center -->
                <div class="row g-3 justify-content-center">
                    <!-- Cards ajustados para col-md-6 em telas médias para melhor espaçamento, mas mantendo a classe col-md-4 para ser flexível. -->
                    <div class="col-md-4 col-lg-4">
                        <div class="schedule-card">
                            <h5 class="text-warning">Manhã</h5>
                            <p class="text-white-50">9h - 12h</p>
                            <small class="text-white-50">Ideal para avaliações</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="schedule-card">
                            <h5 class="text-warning">Tarde</h5>
                            <p class="text-white-50">14h - 18h</p>
                            <small class="text-white-50">Entrega de equipamentos</small>
                        </div>
                    </div>
                    <!-- O terceiro item foi removido, e a centralização resolve o alinhamento dos dois restantes. -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const phoneInput = document.getElementById('phone');
    
    // Validação do campo de arquivo
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSize = file.size / 1024 / 1024; // Converte para MB
                const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                
                if (fileSize > 16) {
                    alert('O arquivo deve ter no máximo 16MB');
                    this.value = '';
                    return;
                }
                
                if (!allowedTypes.includes(file.type)) {
                    alert('Apenas arquivos JPG, PNG e PDF são permitidos');
                    this.value = '';
                    return;
                }
            }
        });
    }

    // Máscara para o campo de telefone
    if(phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length > 10) {
                // Celular com 9 dígitos + DDD: (XX) XXXXX-XXXX
                value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            } else if (value.length > 6) {
                // Fixo ou celular com 8 dígitos: (XX) XXXX-XXXX
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else if (value.length > 2) {
                // Apenas o DDD e início do número
                value = value.replace(/^(\d{2})(\d*)/, '($1) $2');
            } else if (value.length > 0) {
                // Início do DDD
                value = value.replace(/^(\d*)/, '($1');
            }
            e.target.value = value;
        });
    }
});
</script>

<?php
include 'includes/footer.php';
?>