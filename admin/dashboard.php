<?php
require_once '../config.php';
requireLogin();

// --- BUSCA DE DADOS PARA O DASHBOARD ---
$total_contacts = $db->fetchOne("SELECT COUNT(id) as count FROM contact_submission")['count'];
$total_faqs = $db->fetchOne("SELECT COUNT(id) as count FROM faq WHERE is_active = TRUE")['count'];
$total_news = $db->fetchOne("SELECT COUNT(id) as count FROM news_item")['count'];
$total_times = $db->fetchOne("SELECT COUNT(id) as count FROM available_time WHERE is_active = TRUE")['count'];
$recent_contacts = $db->fetchAll("SELECT id, name, email, created_at FROM contact_submission ORDER BY created_at DESC LIMIT 5");

$page_title = "Dashboard";
// Inclui o header correto do admin
include 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-3 fw-bold"><?php echo $total_contacts; ?></div>
                    <div class="text-muted">Contatos Recebidos</div>
                </div>
                <i class="fas fa-envelope fa-2x text-primary opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-3 fw-bold"><?php echo $total_faqs; ?></div>
                    <div class="text-muted">FAQs Ativas</div>
                </div>
                <i class="fas fa-question-circle fa-2x text-success opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
             <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-3 fw-bold"><?php echo $total_news; ?></div>
                    <div class="text-muted">Notícias</div>
                </div>
                <i class="fas fa-newspaper fa-2x text-warning opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
             <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-3 fw-bold"><?php echo $total_times; ?></div>
                    <div class="text-muted">Horários Ativos</div>
                </div>
                <i class="fas fa-clock fa-2x text-danger opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4>Contatos Recentes</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_contacts)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_contacts as $contact): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                    <td><?php echo formatDateTime($contact['created_at']); ?></td>
                                    <td>
                                        <a href="view_contact.php?id=<?php echo $contact['id']; ?>" class="btn btn-sm btn-outline-primary" title="Ver Contato">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="manage_contacts.php" class="btn btn-primary">
                            <i class="fas fa-list me-2"></i>Ver Todos os Contatos
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted p-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>Nenhum contato recebido ainda.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
   <div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Acesso Rápido</h4>
        </div>
        <div class="card-body">
            <div class="d-grid gap-2">
                <a href="manage_times.php" class="btn btn-outline-primary">
                    <i class="fas fa-clock me-2"></i>Gerenciar Horários
                </a>
                <a href="manage_faq.php" class="btn btn-outline-success">
                    <i class="fas fa-question-circle me-2"></i>Gerenciar FAQs
                </a>
                <a href="manage_news.php" class="btn btn-outline-warning">
                    <i class="fas fa-newspaper me-2"></i>Gerenciar Notícias
                </a>
                 <a href="manage_company_info.php" class="btn btn-outline-info">
                    <i class="fas fa-edit me-2"></i>Editar Informações
                </a>
            </div>
        </div>
    </div>
</div>

<?php
// Inclui o footer correto do admin
include 'includes/footer.php';
?>