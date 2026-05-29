<?php
// index.php - Página Inicial da ONG
if (session_status() === PHP_SESSION_NONE) session_start();
$logado = isset($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ONG Mãos que Ajudam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-ong">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-heart-fill me-2"></i>Mãos que Ajudam
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house me-1"></i>Início</a></li>
                <?php if ($logado): ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="listar_doacoes.php"><i class="bi bi-list-ul me-1"></i>Doações</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Sair</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-person me-1"></i>Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro.php"><i class="bi bi-person-plus me-1"></i>Cadastrar</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero-section">
    <div class="container">
        <h1><i class="bi bi-heart-fill me-3"></i>Mãos que Ajudam</h1>
        <p>Uma organização dedicada a transformar vidas por meio da solidariedade. Cada doação faz a diferença na vida de quem mais precisa.</p>
        <?php if ($logado): ?>
            <a href="dashboard.php" class="btn btn-light btn-lg me-3 fw-bold">
                <i class="bi bi-speedometer2 me-2"></i>Acessar Sistema
            </a>
            <a href="nova_doacao.php" class="btn btn-laranja btn-lg fw-bold">
                <i class="bi bi-plus-circle me-2"></i>Registrar Doação
            </a>
        <?php else: ?>
            <a href="cadastro.php" class="btn btn-light btn-lg me-3 fw-bold">
                <i class="bi bi-person-plus me-2"></i>Criar Conta
            </a>
            <a href="login.php" class="btn btn-laranja btn-lg fw-bold">
                <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
            </a>
        <?php endif; ?>
    </div>
</section>

<!-- SOBRE -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col">
                <h2 class="fw-bold" style="color: var(--verde)">Nossa Missão</h2>
                <p class="text-muted lead">Acreditamos que pequenas ações geram grandes mudanças</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-ong h-100 text-center p-4">
                    <div class="mb-3" style="font-size:3rem; color: var(--verde)">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h5 class="fw-bold">Coleta de Doações</h5>
                    <p class="text-muted">Recebemos alimentos, roupas, brinquedos e materiais escolares para famílias em vulnerabilidade social.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-ong h-100 text-center p-4">
                    <div class="mb-3" style="font-size:3rem; color: var(--laranja)">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h5 class="fw-bold">Comunidade</h5>
                    <p class="text-muted">Mais de 500 famílias atendidas mensalmente graças à generosidade de nossos doadores voluntários.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-ong h-100 text-center p-4">
                    <div class="mb-3" style="font-size:3rem; color: #1565c0">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5 class="fw-bold">Transparência</h5>
                    <p class="text-muted">Todas as doações são registradas e acompanhadas em nosso sistema para garantir total transparência.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5" style="background: #e8f5e9">
    <div class="container text-center">
        <h3 class="fw-bold mb-3" style="color: var(--verde)">Faça parte dessa corrente do bem</h3>
        <p class="text-muted mb-4">Crie sua conta gratuitamente e comece a registrar suas doações hoje mesmo.</p>
        <?php if (!$logado): ?>
            <a href="cadastro.php" class="btn btn-ong btn-lg">
                <i class="bi bi-heart me-2"></i>Quero Ajudar
            </a>
        <?php else: ?>
            <a href="nova_doacao.php" class="btn btn-ong btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Registrar Doação
            </a>
        <?php endif; ?>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="container">
        <p class="mb-1"><i class="bi bi-heart-fill text-danger me-2"></i>ONG Mãos que Ajudam &copy; <?= date('Y') ?></p>
        <small>Sistema de Gerenciamento de Doações</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
