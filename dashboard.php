<?php
// dashboard.php - Painel de Controle
require_once 'includes/auth.php';
require_once 'includes/conexao.php';

// Estatísticas
$total_doacoes = $conn->query("SELECT COUNT(*) as total FROM doacoes")->fetch_assoc()['total'];
$total_itens   = $conn->query("SELECT SUM(quantidade) as total FROM doacoes")->fetch_assoc()['total'] ?? 0;
$total_usuarios = $conn->query("SELECT COUNT(*) as total FROM usuarios")->fetch_assoc()['total'];

// Últimas doações
$ultimas = $conn->query("SELECT * FROM doacoes ORDER BY criado_em DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - ONG Mãos que Ajudam</title>
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
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="nova_doacao.php"><i class="bi bi-plus-circle me-1"></i>Nova Doação</a></li>
                <li class="nav-item"><a class="nav-link" href="listar_doacoes.php"><i class="bi bi-list-ul me-1"></i>Doações</a></li>
                <li class="nav-item ms-lg-3">
                    <span class="navbar-text me-3">
                        <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light btn-sm" href="logout.php">
                        <i class="bi bi-box-arrow-right me-1"></i>Sair
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTEÚDO -->
<div class="container py-5">

    <!-- Boas-vindas -->
    <div class="mb-4">
        <h3 class="fw-bold" style="color: var(--verde)">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </h3>
        <p class="text-muted">Bem-vindo, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>! Aqui está o resumo do sistema.</p>
    </div>

    <!-- Cards de estatísticas -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card stat-verde">
                <div class="stat-number"><?= $total_doacoes ?></div>
                <div class="stat-label"><i class="bi bi-box-seam me-1"></i>Total de Doações</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-laranja">
                <div class="stat-number"><?= $total_itens ?></div>
                <div class="stat-label"><i class="bi bi-layers me-1"></i>Itens Recebidos</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-azul">
                <div class="stat-number"><?= $total_usuarios ?></div>
                <div class="stat-label"><i class="bi bi-people me-1"></i>Voluntários Cadastrados</div>
            </div>
        </div>
    </div>

    <!-- Ações rápidas -->
    <div class="row g-3 mb-5">
        <div class="col-12">
            <h5 class="fw-bold text-muted mb-3">Ações Rápidas</h5>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="nova_doacao.php" class="btn btn-ong w-100 py-3">
                <i class="bi bi-plus-circle d-block mb-1" style="font-size:1.5rem"></i>
                Nova Doação
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="listar_doacoes.php" class="btn btn-outline-success w-100 py-3">
                <i class="bi bi-list-ul d-block mb-1" style="font-size:1.5rem"></i>
                Ver Doações
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="cadastro.php" class="btn btn-outline-primary w-100 py-3">
                <i class="bi bi-person-plus d-block mb-1" style="font-size:1.5rem"></i>
                Novo Usuário
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="index.php" class="btn btn-outline-secondary w-100 py-3">
                <i class="bi bi-house d-block mb-1" style="font-size:1.5rem"></i>
                Página Inicial
            </a>
        </div>
    </div>

    <!-- Últimas doações -->
    <div class="card card-ong">
        <div class="card-header-ong">
            <i class="bi bi-clock-history me-2"></i>Últimas Doações Registradas
        </div>
        <div class="card-body p-0">
            <?php if ($ultimas->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0 tabela-doacoes">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Quantidade</th>
                            <th>Descrição</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($d = $ultimas->fetch_assoc()): ?>
                        <tr>
                            <td><?= $d['id'] ?></td>
                            <td><strong><?= htmlspecialchars($d['item']) ?></strong></td>
                            <td><span class="badge-qtd"><?= $d['quantidade'] ?></span></td>
                            <td class="text-muted"><?= htmlspecialchars(mb_strimwidth($d['descricao'], 0, 60, '...')) ?></td>
                            <td class="text-muted small"><?= date('d/m/Y H:i', strtotime($d['criado_em'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox" style="font-size:3rem"></i>
                    <p class="mt-2">Nenhuma doação registrada ainda.</p>
                    <a href="nova_doacao.php" class="btn btn-ong">Registrar primeira doação</a>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($ultimas->num_rows > 0): ?>
        <div class="card-footer text-end bg-white border-0 pb-3 pe-3">
            <a href="listar_doacoes.php" class="btn btn-outline-success btn-sm">
                Ver todas <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <?php endif; ?>
    </div>

</div>

<footer>
    <div class="container">
        <p class="mb-1"><i class="bi bi-heart-fill text-danger me-2"></i>ONG Mãos que Ajudam &copy; <?= date('Y') ?></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
