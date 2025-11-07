<?php
require_once '../config.php';
requireLogin();

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$info_item = null;

// Handle POST request for saving edits
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $info_value = sanitize($_POST['info_value']);

    if ($id) {
        $db->query("UPDATE company_info SET info_value = ? WHERE id = ?", [$info_value, $id]);
        flashMessage('Informação atualizada com sucesso!', 'success');
    }
    redirect('manage_company_info.php');
}

// Handle GET requests to display the list or the edit form
if ($action === 'edit' && $id) {
    $info_item = $db->fetchOne("SELECT * FROM company_info WHERE id = ?", [$id]);
    if (!$info_item) {
        flashMessage('Informação não encontrada.', 'danger');
        redirect('manage_company_info.php');
    }
    $page_title = "Editar Informação";
} else {
    $page_title = "Informações da Empresa";
    $company_info = $db->fetchAll("SELECT * FROM company_info ORDER BY id ASC");
}

// Helper function to make keys more readable (e.g., company_name -> Company Name)
function format_info_key($key) {
    return ucwords(str_replace('_', ' ', $key));
}

include 'includes/header.php';

if ($action === 'edit'):
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><?php echo $page_title; ?>: "<?php echo format_info_key(htmlspecialchars($info_item['info_key'])); ?>"</h3>
    <a href="manage_company_info.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar para a Lista
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="manage_company_info.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($info_item['id']); ?>">
            
            <div class="mb-3">
                <label for="info_key" class="form-label">Campo</label>
                <input type="text" class="form-control" id="info_key" value="<?php echo format_info_key(htmlspecialchars($info_item['info_key'])); ?>" disabled readonly>
            </div>

            <div class="mb-3">
                <label for="info_value" class="form-label">Valor *</label>
                <textarea class="form-control" id="info_value" name="info_value" rows="4" required><?php echo htmlspecialchars($info_item['info_value']); ?></textarea>
                <small class="form-text text-muted"><?php echo htmlspecialchars($info_item['description']); ?></small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Salvar Alterações
            </button>
        </form>
    </div>
</div>

<?php else: // Default action: 'list' ?>

<div class="mb-4">
    <h3>Gerenciar Informações da Empresa</h3>
    <p class="text-muted">Atualize as informações que aparecem em todo o site, como no rodapé e na página de contato.</p>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (!empty($company_info)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Campo</th>
                        <th>Valor Atual</th>
                        <th>Descrição</th>
                        <th>Última Atualização</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($company_info as $info): ?>
                    <tr>
                        <td><strong><?php echo format_info_key($info['info_key']); ?></strong></td>
                        <td><?php echo htmlspecialchars(mb_strimwidth($info['info_value'], 0, 70, "...")); ?></td>
                        <td class="text-muted"><?php echo htmlspecialchars($info['description'] ?: '-'); ?></td>
                        <td><?php echo formatDateTime($info['updated_at']); ?></td>
                        <td class="text-end">
                            <a href="manage_company_info.php?action=edit&id=<?php echo $info['id']; ?>" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit me-2"></i>Editar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center text-muted py-5">
            <i class="fas fa-building fa-3x mb-3"></i>
            <h5>Nenhuma informação da empresa encontrada.</h5>
            <p>Execute o script SQL inicial para popular esta tabela.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php endif; ?>

<?php
include 'includes/footer.php';
?>