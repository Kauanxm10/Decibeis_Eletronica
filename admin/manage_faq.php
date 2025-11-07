<?php
require_once '../config.php';
requireLogin();

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$faq_item = null;

// Handle POST requests for saving and deleting
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_action = $_POST['action'] ?? '';

    if ($post_action === 'save') {
        $id = $_POST['id'] ?? null;
        $question = sanitize($_POST['question']);
        $answer = sanitize($_POST['answer']);
        $order_position = filter_var($_POST['order_position'], FILTER_VALIDATE_INT, ['options' => ['default' => 0]]);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        $data = [
            'question' => $question,
            'answer' => $answer,
            'order_position' => $order_position,
            'is_active' => $is_active
        ];

        if ($id) {
            $db->query("UPDATE faq SET question = :question, answer = :answer, order_position = :order_position, is_active = :is_active WHERE id = :id", array_merge($data, ['id' => $id]));
            flashMessage('FAQ atualizada com sucesso!', 'success');
        } else {
            $db->insert('faq', $data);
            flashMessage('FAQ adicionada com sucesso!', 'success');
        }
        redirect('manage_faq.php');

    } elseif ($post_action === 'delete') {
        $id_to_delete = $_POST['id'] ?? null;
        if ($id_to_delete) {
            $db->query("DELETE FROM faq WHERE id = ?", [$id_to_delete]);
            flashMessage('FAQ removida com sucesso!', 'danger');
        }
        redirect('manage_faq.php');
    }
}

// Handle GET requests for displaying forms or the list
if ($action === 'edit' && $id) {
    $faq_item = $db->fetchOne("SELECT * FROM faq WHERE id = ?", [$id]);
    if (!$faq_item) {
        flashMessage('FAQ não encontrada.', 'danger');
        redirect('manage_faq.php');
    }
    $page_title = "Editar FAQ";
} elseif ($action === 'add') {
    $page_title = "Adicionar FAQ";
} else {
    $page_title = "Gerenciar FAQ";
    $faqs = $db->fetchAll("SELECT * FROM faq ORDER BY order_position ASC, id DESC");
}

include 'includes/header.php';

if ($action === 'add' || $action === 'edit'):
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><?php echo $page_title; ?></h3>
    <a href="manage_faq.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar para a Lista
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="manage_faq.php" method="POST">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($faq_item['id'] ?? ''); ?>">

            <div class="mb-3">
                <label for="question" class="form-label">Pergunta *</label>
                <input type="text" class="form-control" id="question" name="question" value="<?php echo htmlspecialchars($faq_item['question'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="answer" class="form-label">Resposta *</label>
                <textarea class="form-control" id="answer" name="answer" rows="5" required><?php echo htmlspecialchars($faq_item['answer'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="order_position" class="form-label">Ordem de Exibição</label>
                <input type="number" class="form-control" id="order_position" name="order_position" value="<?php echo htmlspecialchars($faq_item['order_position'] ?? '0'); ?>" style="max-width: 150px;">
                <small class="form-text text-muted">Perguntas com menor número aparecem primeiro.</small>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo (isset($faq_item['is_active']) && $faq_item['is_active']) || $action === 'add' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_active">
                    Ativa (visível na página pública de FAQ)
                </label>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Salvar FAQ
            </button>
        </form>
    </div>
</div>

<?php else: // Default action: 'list' ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Gerenciar FAQ</h3>
    <a href="manage_faq.php?action=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Adicionar FAQ
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (!empty($faqs)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pergunta</th>
                        <th class="text-center">Ordem</th>
                        <th class="text-center">Status</th>
                        <th>Data de Criação</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($faq['question']); ?></strong>
                            <br><small class="text-muted"><?php echo htmlspecialchars(mb_strimwidth($faq['answer'], 0, 100, "...")); ?></small>
                        </td>
                        <td class="text-center"><?php echo $faq['order_position']; ?></td>
                        <td class="text-center">
                            <?php if ($faq['is_active']): ?>
                                <span class="badge bg-success">Ativa</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inativa</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo formatDate($faq['created_at']); ?></td>
                        <td class="text-end">
                            <a href="manage_faq.php?action=edit&id=<?php echo $faq['id']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="manage_faq.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja remover esta FAQ?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">
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
        <?php else: ?>
        <div class="text-center text-muted py-5">
            <i class="fas fa-question-circle fa-3x mb-3"></i>
            <h5>Nenhuma FAQ cadastrada</h5>
            <p>Adicione perguntas frequentes para ajudar seus clientes.</p>
            <a href="manage_faq.php?action=add" class="btn btn-primary mt-2">
                <i class="fas fa-plus me-2"></i>Adicionar Primeira FAQ
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php endif; ?>

<?php
include 'includes/footer.php';
?>