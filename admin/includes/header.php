<?php
// O config.php deve ter sido chamado pela página principal (ex: dashboard.php)
// A sessão já foi iniciada e o login verificado.

// Pega o nome do arquivo atual para saber qual link do menu deve ficar "ativo"
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title ?? 'Painel'); ?> - Admin <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Estilos do seu template para o painel admin */
        :root { --admin-primary: #2c3e50; --admin-secondary: #34495e; --admin-accent: #3498db; }
        body { background-color: #f8f9fa; }
        .admin-sidebar { min-height: 100vh; background-color: var(--admin-primary); box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .admin-sidebar .nav-link { color: #bdc3c7; transition: all 0.3s ease; }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active { background-color: var(--admin-secondary); color: white; }
        .admin-sidebar .nav-link i { margin-right: 0.75rem; width: 20px; text-align: center; }
        .admin-content-header { background-color: white; border-bottom: 1px solid #dee2e6; padding: 1rem 1.5rem; }
        .admin-content-body { padding: 1.5rem; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar collapse vh-100 position-fixed">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white"><i class="fas fa-cog me-2"></i>Admin Panel</h4>
                        <small class="text-white-50"><?php echo SITE_NAME; ?></small>
                    </div>
                   <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
                                <i class="fas fa-tachometer-alt"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'manage_contacts.php') ? 'active' : ''; ?>" href="manage_contacts.php">
                                <i class="fas fa-envelope"></i>Contatos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'manage_faq.php') ? 'active' : ''; ?>" href="manage_faq.php">
                                <i class="fas fa-question-circle"></i>FAQ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'manage_times.php') ? 'active' : ''; ?>" href="manage_times.php">
                                <i class="fas fa-clock"></i>Horários Disponíveis
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'manage_news.php') ? 'active' : ''; ?>" href="manage_news.php">
                                <i class="fas fa-newspaper"></i>Notícias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'manage_company_info.php') ? 'active' : ''; ?>" href="manage_company_info.php">
                                <i class="fas fa-building"></i>Informações
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link" href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i>Ver Site</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Sair</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-0">
                <div class="admin-content-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0"><?php echo htmlspecialchars($page_title ?? 'Página'); ?></h2>
                        <div class="text-muted">
                            <i class="fas fa-user-circle me-2"></i><?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                        </div>
                    </div>
                </div>

                <div class="admin-content-body">
                <?php
                // Exibe as mensagens "flash" de sucesso ou erro
                $flash = getFlashMessage();
                if ($flash):
                ?>
                    <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($flash['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>