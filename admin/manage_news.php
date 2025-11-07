<?php
require_once '../config.php';
requireLogin();

// --- LOGIC & DATA FETCHING ---

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$news_item = null;

// Handle POST requests for saving and deleting
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_action = $_POST['action'] ?? '';

    if ($post_action === 'save') {
        $id = $_POST['id'] ?? null;
        $title = sanitize($_POST['title']);
        $content = sanitize($_POST['content']);
        $url = filter_var($_POST['url'], FILTER_VALIDATE_URL) ? $_POST['url'] : '';
        $image_url = filter_var($_POST['image_url'], FILTER_VALIDATE_URL) ? $_POST['image_url'] : '';
        $published_date = sanitize($_POST['published_date']);

        $data = [
            'title' => $title,
            'content' => $content,
            'url' => $url,
            'image_url' => $image_url,
            'published_date' => $published_date
        ];

        if ($id) {
            $db->query("UPDATE news_item SET title = :title, content = :content, url = :url, image_url = :image_url, published_date = :published_date WHERE id = :id", array_merge($data, ['id' => $id]));
            flashMessage('Notícia atualizada com sucesso!', 'success');
        } else {
            $db->insert('news_item', $data);
            flashMessage('Notícia adicionada com sucesso!', 'success');
        }
        redirect('manage_news.php');

    } elseif ($post_action === 'delete') {
        $id_to_delete = $_POST['id'] ?? null;
        if ($id_to_delete) {
            $db->query("DELETE FROM news_item WHERE id = ?", [$id_to_delete]);
            flashMessage('Notícia removida com sucesso!', 'danger');
        }
        redirect('manage_news.php');
    }
}

// Handle GET requests for displaying forms or the list
if ($action === 'edit' && $id) {
    $news_item = $db->fetchOne("SELECT * FROM news_item WHERE id = ?", [$id]);
    if (!$news_item) {
        flashMessage('Notícia não encontrada.', 'danger');
        redirect('manage_news.php');
    }
    $page_title = "Editar Notícia";
} elseif ($action === 'add') {
    $page_title = "Adicionar Notícia";
} else {
    $page_title = "Gerenciar Notícias";
    $news_items = $db->fetchAll("SELECT * FROM news_item ORDER BY published_date DESC");
}

include 'includes/header.php';

// Display either the form or the list based on the action
if ($action === 'add' || $action === 'edit'):
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><?php echo $page_title; ?></h3>
    <a href="manage_news.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar para a Lista
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="manage_news.php" method="POST">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($news_item['id'] ?? ''); ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Título *</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($news_item['title'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Conteúdo (breve descrição)</label>
                <textarea class="form-control" id="content" name="content" rows="3"><?php echo htmlspecialchars($news_item['content'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL da Notícia Completa (Opcional)</label>
                <input type="url" class="form-control" id="url" name="url" value="<?php echo htmlspecialchars($news_item['url'] ?? ''); ?>" placeholder="https://exemplo.com/noticia">
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">URL da Imagem (Opcional)</label>
                <input type="url" class="form-control" id="image_url" name="image_url" value="<?php echo htmlspecialchars($news_item['image_url'] ?? ''); ?>" placeholder="https://exemplo.com/imagem.jpg">
            </div>
             <div class="mb-3">
                <label for="published_date" class="form-label">Data de Publicação *</label>
                <input type="date" class="form-control" id="published_date" name="published_date" value="<?php echo htmlspecialchars($news_item['published_date'] ?? date('Y-m-d')); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Salvar Notícia
            </button>
        </form>
    </div>
</div>

<?php else: // Default action: 'list' ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Gerenciar Notícias</h3>
    <a href="manage_news.php?action=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Adicionar Notícia
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (!empty($news_items)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Data de Publicação</th>
                        <th>URL</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news_items as $news): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($news['title']); ?></strong>
                            <?php if (!empty($news['content'])): ?>
                                <br><small class="text-muted"><?php echo htmlspecialchars(mb_strimwidth($news['content'], 0, 100, "...")); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?php echo formatDate($news['published_date']); ?></td>
                        <td>
                            <?php if (!empty($news['url'])): ?>
                            <a href="<?php echo htmlspecialchars($news['url']); ?>" target="_blank" class="text-decoration-none">
                                <i class="fas fa-external-link-alt me-1"></i>Ver original
                            </a>
                            <?php else: ?>
                            -
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="manage_news.php?action=edit&id=<?php echo $news['id']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="manage_news.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja remover esta notícia?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
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
            <i class="fas fa-newspaper fa-3x mb-3"></i>
            <h5>Nenhuma notícia cadastrada</h5>
            <p>Adicione notícias para exibir no site.</p>
            <a href="manage_news.php?action=add" class="btn btn-primary mt-2">
                <i class="fas fa-plus me-2"></i>Adicionar Primeira Notícia
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php
include 'includes/footer.php';
?>