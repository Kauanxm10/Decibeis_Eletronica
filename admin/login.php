<?php
// Usamos o config.php que já tem a conexão e as funções
require_once '../config.php';

// Se o admin já estiver logado, redireciona para o painel principal
if (isLoggedIn()) {
    redirect('dashboard.php');
}

// Processa o formulário quando ele é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        flashMessage('Preencha todos os campos.', 'danger');
        redirect('login.php');
    }

    $user = $db->fetchOne("SELECT * FROM users WHERE username = ? AND is_admin = TRUE", [$username]);

    // Verifica se o usuário existe e se a senha está correta
    if ($user && password_verify($password, $user['password_hash'])) {
        // Login bem-sucedido!
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        
        flashMessage('Login realizado com sucesso!', 'success');
        redirect('dashboard.php');
    } else {
        // Login falhou
        flashMessage('Usuário ou senha inválidos.', 'danger');
        redirect('login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Decibéis Eletrônica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS do seu novo design de login */
        body { background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: white; border-radius: 15px; padding: 3rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1); max-width: 400px; width: 100%; }
        .login-header { text-align: center; margin-bottom: 2rem; }
        .login-header h2 { color: #2c3e50; margin-bottom: 0.5rem; }
        .login-header p { color: #7f8c8d; }
        .form-control { border-radius: 10px; padding: 0.75rem 1rem; border: 2px solid #ecf0f1; }
        .form-control:focus { border-color: #3498db; box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25); }
        .btn-login { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); border: none; border-radius: 10px; padding: 0.75rem 2rem; font-weight: 600; width: 100%; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3); }
        .back-link { text-align: center; margin-top: 1.5rem; }
        .back-link a { color: #7f8c8d; text-decoration: none; }
        .back-link a:hover { color: #2c3e50; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h2><i class="fas fa-shield-alt me-2"></i>Admin Login</h2>
            <p>Decibéis Eletrônica - Painel Administrativo</p>
        </div>
        
        <?php
        // Usa a função getFlashMessage() do seu config.php para exibir os erros
        $flash = getFlashMessage();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($flash['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="username" class="form-label">Usuário</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">Senha</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Entrar
            </button>
        </form>
        
        <div class="back-link">
            <a href="../index.php">
                <i class="fas fa-arrow-left me-1"></i>Voltar ao site
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>