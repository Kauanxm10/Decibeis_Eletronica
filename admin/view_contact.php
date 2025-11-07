<?php
require_once '../config.php';
requireLogin();

// --- 1. PEGAR E VALIDAR O ID DO CONTATO ---
// Verifica se o ID foi passado pela URL e se é um número
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    flashMessage('ID de contato inválido.', 'danger');
    redirect('dashboard.php'); // Redireciona se o ID for inválido
}
$contact_id = (int)$_GET['id'];


// --- 2. BUSCAR O CONTATO NO BANCO DE DADOS ---
$contact = $db->fetchOne("SELECT * FROM contact_submission WHERE id = ?", [$contact_id]);

// Se nenhum contato for encontrado com esse ID, redireciona de volta
if (!$contact) {
    flashMessage('Contato não encontrado.', 'danger');
    redirect('manage_contacts.php'); // O ideal é uma página que lista todos os contatos
}


// --- 3. PREPARAR PARA EXIBIÇÃO ---
$page_title = "Visualizar Contato";
include 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Detalhes do Contato</h3>
    <a href="manage_contacts.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar para a Lista
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Informações do Contato</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Nome:</strong></div>
                    <div class="col-sm-9"><?php echo htmlspecialchars($contact['name']); ?></div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Email:</strong></div>
                    <div class="col-sm-9">
                        <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>"><?php echo htmlspecialchars($contact['email']); ?></a>
                    </div>
                </div>
                
                <?php if (!empty($contact['phone'])): ?>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Telefone:</strong></div>
                    <div class="col-sm-9"><?php echo htmlspecialchars($contact['phone']); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($contact['appointment_date']) || !empty($contact['appointment_time'])): ?>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Agendamento:</strong></div>
                    <div class="col-sm-9">
                        <?php if (!empty($contact['appointment_date'])) echo formatDate($contact['appointment_date']); // Usa a função do config.php ?>
                        <?php if (!empty($contact['appointment_time'])) echo ' às ' . htmlspecialchars($contact['appointment_time']); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Data de Envio:</strong></div>
                    <div class="col-sm-9"><?php echo formatDateTime($contact['created_at']); // Usa a função do config.php ?></div>
                </div>
                
                <?php if (!empty($contact['message'])): ?>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Mensagem:</strong></div>
                    <div class="col-sm-9">
                        <div class="p-3 bg-light rounded border">
                            <?php echo nl2br(htmlspecialchars($contact['message'])); // nl2br para manter quebras de linha ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($contact['file_path'])): ?>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Arquivo Anexado:</strong></div>
                    <div class="col-sm-9">
                        <a href="../<?php echo htmlspecialchars($contact['file_path']); ?>" class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fas fa-download me-2"></i>
                            <?php echo htmlspecialchars(basename($contact['file_path'])); // basename() pega só o nome do arquivo ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm">
             <div class="card-header">
                <h5>Ações Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-envelope me-2"></i>Responder por Email
                    </a>
                    
                    <?php if (!empty($contact['phone'])): ?>
                    <a href="tel:<?php echo htmlspecialchars(preg_replace('/\D/', '', $contact['phone'])); ?>" class="btn btn-outline-success">
                        <i class="fas fa-phone me-2"></i>Ligar
                    </a>
                    <?php endif; ?>
                    
                    <a href="delete_contact.php?id=<?php echo $contact['id']; ?>" class="btn btn-outline-danger" onclick="return confirm('Tem certeza que deseja remover este contato? Esta ação não pode ser desfeita.')">
                        <i class="fas fa-trash me-2"></i>Remover Contato
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>