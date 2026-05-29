<?php
// nova_doacao.php - Cadastro de Doação
require_once 'includes/auth.php';
require_once 'includes/conexao.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item       = trim($_POST['item'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);
    $descricao  = trim($_POST['descricao'] ?? '');
    $usuario_id = $_SESSION['usuario_id'];

    if (empty($item)) {
        $erro = 'O nome do item é obrigatório.';
    } elseif ($quantidade <= 0) {
        $erro = 'A quantidade deve ser maior que zero.';
    } else {
        $stmt = $conn->prepare("INSERT INTO doacoes (usuario_id, item, quantidade, descricao) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $usuario_id, $item, $quantidade, $descricao);
        if ($stmt->execute()) {
            $sucesso = 'Doação registrada com sucesso!';
        } else {
            $erro = 'Erro ao registrar doação. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nova Doação - ONG Mãos que Ajudam</title>
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
                <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="nova_doacao.php"><i class="bi bi-plus-circle me-1"></i>Nova Doação</a></li>
                <li class="nav-item"><a class="nav-link" href="listar_doacoes.php"><i class="bi bi-list-ul me-1"></i>Doações</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Sair</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php" style="color: var(--verde)">Dashboard</a></li>
                    <li class="breadcrumb-item active">Nova Doação</li>
                </ol>
            </nav>

            <div class="card card-ong">
                <div class="card-header-ong">
                    <i class="bi bi-plus-circle me-2"></i>Registrar Nova Doação
                </div>
                <div class="card-body p-4">

                    <?php if ($erro): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($erro) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($sucesso): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i><?= $sucesso ?>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="nova_doacao.php" class="btn btn-ong">
                                <i class="bi bi-plus me-1"></i>Registrar outra
                            </a>
                            <a href="listar_doacoes.php" class="btn btn-outline-success">
                                <i class="bi bi-list-ul me-1"></i>Ver todas
                            </a>
                        </div>
                    <?php else: ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Item Doado *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-box"></i></span>
                                <input type="text" name="item" class="form-control"
                                       value="<?= htmlspecialchars($_POST['item'] ?? '') ?>"
                                       placeholder="Ex: Arroz, Roupas, Brinquedos..." required>
                            </div>
                            <div class="form-text">Descreva o tipo de item recebido</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantidade *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-123"></i></span>
                                <input type="number" name="quantidade" class="form-control"
                                       value="<?= htmlspecialchars($_POST['quantidade'] ?? '') ?>"
                                       min="1" placeholder="0" required>
                                <span class="input-group-text">unid.</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="4"
                                      placeholder="Informações adicionais sobre a doação (opcional)..."><?= htmlspecialchars($_POST['descricao'] ?? '') ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-ong">
                                <i class="bi bi-check-circle me-2"></i>Salvar Doação
                            </button>
                            <a href="dashboard.php" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>

                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<footer>
    <div class="container">
        <p class="mb-0"><i class="bi bi-heart-fill text-danger me-2"></i>ONG Mãos que Ajudam &copy; <?= date('Y') ?></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
