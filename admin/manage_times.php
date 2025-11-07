<?php
require_once '../config.php';
requireLogin();

// Pega a ação da URL, o padrão é 'list'
$action = $_GET['action'] ?? 'list';
// Pega o ID da URL, se existir
$id = $_GET['id'] ?? null;

$time = null; // Inicializa a variável

// --- LÓGICA DE PROCESSAMENTO DE FORMULÁRIOS (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_action = $_POST['action'] ?? '';

    if ($post_action === 'save') {
        $id = $_POST['id'] ?? null;
        $time_slot = sanitize($_POST['time_slot']);
        $description = sanitize($_POST['description']);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        $data = [
            'time_slot' => $time_slot,
            'description' => $description,
            'is_active' => $is_active
        ];

        if ($id) {
            // Atualizar
            $db->query("UPDATE available_time SET time_slot = :time_slot, description = :description, is_active = :is_active WHERE id = :id", array_merge($data, ['id' => $id]));
            flashMessage('Horário atualizado com sucesso!', 'success');
        } else {
            // Inserir
            $db->insert('available_time', $data);
            flashMessage('Horário adicionado com sucesso!', 'success');
        }
        redirect('manage_times.php');

    } elseif ($post_action === 'delete') {
        $id_to_delete = $_POST['id'] ?? null;
        if ($id_to_delete) {
            $db->query("DELETE FROM available_time WHERE id = ?", [$id_to_delete]);
            flashMessage('Horário removido com sucesso!', 'danger');
        }
        redirect('manage_times.php');
    }
}


// --- LÓGICA PARA EXIBIR A PÁGINA (GET) ---
if ($action === 'edit' && $id) {
    $time = $db->fetchOne("SELECT * FROM available_time WHERE id = ?", [$id]);
    if (!$time) {
        flashMessage('Horário não encontrado.', 'danger');
        redirect('manage_times.php');
    }
    $page_title = "Editar Horário";
} elseif ($action === 'add') {
    $page_title = "Adicionar Horário";
} else {
    $page_title = "Horários Disponíveis";
    $times = $db->fetchAll("SELECT * FROM available_time ORDER BY time_slot ASC");
}

include 'includes/header.php';

// Se a ação for 'add' ou 'edit', mostra o formulário. Caso contrário, mostra a lista.
if ($action === 'add' || $action === 'edit'):
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><?php echo $page_title; ?></h3>
    <a href="manage_times.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar para a Lista
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="manage_times.php" method="POST">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($time['id'] ?? ''); ?>">

            <div class="mb-3">
                <label for="time_slot" class="form-label">Horário (ex: 09:00, 14:30) *</label>
                <input type="time" class="form-control" id="time_slot" name="time_slot" value="<?php echo htmlspecialchars($time['time_slot'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrição (Opcional)</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($time['description'] ?? ''); ?>" placeholder="Ex: Manhã - Horário popular">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo (isset($time['is_active']) && $time['is_active']) || $action === 'add' ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_active">
                    Ativo (visível no formulário de contato)
                </label>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Salvar Horário
            </button>
        </form>
    </div>
</div>

<?php else: // Ação padrão: 'list' ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Gerenciar Horários Disponíveis</h3>
    <a href="manage_times.php?action=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Adicionar Horário
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (!empty($times)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Horário</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($times as $time_item): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($time_item['time_slot']); ?></strong></td>
                        <td><?php echo htmlspecialchars($time_item['description'] ?: '-'); ?></td>
                        <td>
                            <?php if ($time_item['is_active']): ?>
                                <span class="badge bg-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo formatDate($time_item['created_at']); ?></td>
                        <td class="text-end">
                            <a href="manage_times.php?action=edit&id=<?php echo $time_item['id']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="manage_times.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja remover este horário?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $time_item['id']; ?>">
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
            <i class="fas fa-clock fa-3x mb-3"></i>
            <h5>Nenhum horário cadastrado</h5>
            <p>Comece adicionando os horários disponíveis para agendamento.</p>
            <a href="manage_times.php?action=add" class="btn btn-primary mt-2">
                <i class="fas fa-plus me-2"></i>Adicionar Primeiro Horário
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php
include 'includes/footer.php';
?>