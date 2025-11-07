<?php
require_once '../config.php';
requireLogin();

// --- LÓGICA DE DELEÇÃO (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_to_delete = $_POST['id'] ?? null;
    if ($id_to_delete) {
        // Opcional: deletar o arquivo anexado do servidor
        $contact = $db->fetchOne("SELECT file_path FROM contact_submission WHERE id = ?", [$id_to_delete]);
        if ($contact && !empty($contact['file_path']) && file_exists('../' . $contact['file_path'])) {
            unlink('../' . $contact['file_path']);
        }
        
        // Deleta o registro do banco
        $db->query("DELETE FROM contact_submission WHERE id = ?", [$id_to_delete]);
        flashMessage('Contato removido com sucesso!', 'danger');
    }
    redirect('manage_contacts.php');
}


// --- LÓGICA DE PAGINAÇÃO E BUSCA (GET) ---
$items_per_page = 10;
$total_contacts = $db->fetchOne("SELECT COUNT(id) as count FROM contact_submission")['count'];
$total_pages = ceil($total_contacts / $items_per_page);
$current_page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1, 'max_range' => $total_pages]]);
$offset = ($current_page - 1) * $items_per_page;

// CORREÇÃO APLICADA AQUI:
// Forçamos os parâmetros de LIMIT e OFFSET a serem tratados como números inteiros (PDO::PARAM_INT)
$stmt = $db->getConnection()->prepare("SELECT * FROM contact_submission ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$contacts = $stmt->fetchAll();
$page_title = "Contatos Recebidos";
include 'includes/header.php';
?>

<div class="mb-4">
    <h3>Contatos Recebidos</h3>
    <p class="text-muted">Visualize e gerencie todos os contatos enviados através do site</p>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (!empty($contacts)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Agendamento</th>
                        <th>Data de Envio</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($contact['name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($contact['email']); ?></td>
                        <td><?php echo htmlspecialchars($contact['phone'] ?: '-'); ?></td>
                        <td>
                            <?php if (!empty($contact['appointment_date'])): ?>
                                <?php echo formatDate($contact['appointment_date']); ?>
                                <?php if (!empty($contact['appointment_time'])) echo ' às ' . htmlspecialchars($contact['appointment_time']); ?>
                            <?php else: ?>
                                <span class="text-muted">Sem agendamento</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo formatDateTime($contact['created_at']); ?></td>
                        <td class="text-end">
                            <a href="view_contact.php?id=<?php echo $contact['id']; ?>" class="btn btn-sm btn-outline-primary me-1" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="manage_contacts.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja remover este contato permanentemente?')">
                                <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Remover">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($total_pages > 1): ?>
        <nav aria-label="Navegação de páginas" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $current_page - 1; ?>">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Próxima</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
        
        <?php else: ?>
        <div class="text-center text-muted py-5">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <h5>Nenhum contato recebido</h5>
            <p>Os contatos enviados através do formulário do site aparecerão aqui.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
include 'includes/footer.php';
?>