<?php
// O logout precisa do config.php para usar as funções de sessão e redirect
require_once '../config.php';

// Limpa todas as variáveis da sessão
$_SESSION = [];

// Destrói o cookie de sessão para garantir um logout completo
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrói a sessão
session_destroy();

// Usa sua função flashMessage para enviar uma mensagem de sucesso para a tela de login
flashMessage('Você saiu do sistema com segurança.', 'success');
redirect('login.php');
?>