<?php
// O $companyInfo deve ser definido na página principal (index.php, contact.php)
// ANTES de incluir este header.

// As variáveis $page_description e $page_keywords devem ser definidas na página principal.

// Fallbacks de SEO: Se a página não definir a variável, ela usa um valor genérico.
$description_fallback = $companyInfo['company_name'] . ' - Especialistas em reparo e manutenção de equipamentos de áudio profissional.';
$keywords_fallback = 'reparo áudio profissional, conserto mesas de som, Decibéis Eletrônica, serviço técnico';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título da Página (Definido por $page_title na página principal) -->
    <title><?php echo htmlspecialchars($page_title ?? $companyInfo['company_name'] ?? 'Decibéis Eletrônica'); ?></title> 
    
    <!-- Metatags de SEO Essenciais -->
    <meta name="description" content="<?php echo htmlspecialchars($page_description ?? $description_fallback); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords ?? $keywords_fallback); ?>">

    <!-- Metatags Open Graph (Para redes sociais e WhatsApp) -->
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title ?? $companyInfo['company_name'] ?? 'Decibéis Eletrônica'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description ?? $description_fallback); ?>">
    <meta property="og:url" content="https://xn--decibiseletrnica-fqb9r.com.br/<?php echo basename($_SERVER['PHP_SELF']); ?>">
    <meta property="og:type" content="website">

    <!-- CSS e Bibliotecas -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Seu CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <!-- SUA NOVA LOGO -->
               
                <?php echo htmlspecialchars($companyInfo['company_name'] ?? 'Decibéis Eletrônica'); ?>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="technical.php">Técnico</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contato</a></li>
                    <li class="nav-item"><a class="nav-link" href="faq.php">FAQ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <div class="container mt-5 pt-4">
