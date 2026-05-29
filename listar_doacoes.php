<?php
// listar_doacoes.php - Lista de Doações com CRUD completo
require_once 'includes/auth.php';
require_once 'includes/conexao.php';

$mensagem = '';
$tipo_msg = '';

// DELETAR
if (isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $stmt = $conn->prepare("DELETE FROM doacoes WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $mensagem = 'Doação removida com sucesso.';
        $tipo_msg = 'success';
    } else {
        $mensagem = 'Erro ao remover doação.';
        $tipo_msg = 'danger';
    }
}

// EDITAR - salvar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_id'])) {
    $id         = intval($_POST['editar_id']);
    $item       = trim($_POST['item']);
    $quantidade = intval($_POST['quantidade']);
    $descricao  = trim($_POST['descricao']);

    $stmt = $conn->prepare("UPDATE doacoes SET item=?, quantidade=?, descricao=? WHERE id=?");
    $stmt->bind_param("sisi", $item, $quantidade, $descricao, $id);
    if ($stmt->execute()) {
        $mensagem = 'Doação atualizada com sucesso!';
        $tipo_msg = 'success';
    } else {
        $mensagem = 'Erro ao atualizar.';
        $tipo_msg = 'danger';
    }
}

// Buscar doações
$busca = trim($_GET['busca'] ?? '');
if ($busca !== '') {
    $b = "%$busca%";
    $stmt = $conn->prepare("SELECT * FROM doacoes WHERE item LIKE ? OR descricao LIKE ? ORDER BY criado_em DESC");
    $stmt->bind_param("ss", $b, $b);
    $stmt->execute();
    $doacoes = $stmt->get_result();
} else {
    $doacoes = $conn->query("SELECT * FROM doacoes ORDER BY criado_em DESC");
}

// Dados para edição
$editar = null;
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $r = $conn->prepare("SELECT * FROM doacoes WHERE id = ?");
    $r->bind_param("i", $id);
    $r->execute();
    $editar = $r->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doações - ONG Mãos que Ajudam</title>
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
                <li class="nav-item"><a class="nav-link" href="nova_doacao.php"><i class="bi bi-plus-circle me-1"></i>Nova Doação</a></li>
                <li class="nav-item"><a class="nav-link active" href="listar_doacoes.php"><i class="bi bi-list-ul me-1"></i>Doações</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Sair</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php" style="color: var(--verde)">Dashboard</a></li>
            <li class="breadcrumb-item active">Lista de Doações</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0" style="color: var(--verde)">
            <i class="bi bi-list-ul me-2"></i>Doações Registradas
        </h3>
        <a href="nova_doacao.php" class="btn btn-ong">
            <i class="bi bi-plus-circle me-2"></i>Nova Doação
        </a>
    </div>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipo_msg ?> alert-dismissible fade show">
            <i class="bi bi-<?= $tipo_msg === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
            <?= htmlspecialchars($mensagem) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Modal de Edição -->
    <?php if ($editar): ?>
    <div class="card card-ong mb-4" id="form-editar">
        <div class="card-header-ong">
            <i class="bi bi-pencil me-2"></i>Editar Doação #<?= $editar['id'] ?>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="">
                <input type="hidden" name="editar_id" value="<?= $editar['id'] ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Item *</label>
                        <input type="text" name="item" class="form-control"
                               value="<?= htmlspecialchars($editar['item']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Quantidade *</label>
                        <input type="number" name="quantidade" class="form-control"
                               value="<?= $editar['quantidade'] ?>" min="1" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($editar['descricao']) ?></textarea>
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-ong">
                            <i class="bi bi-check-circle me-2"></i>Salvar Alterações
                        </button>
                        <a href="listar_doacoes.php" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Busca -->
    <div class="card card-ong mb-4">
        <div class="card-body py-3">
            <form method="GET" action="" class="d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="busca" class="form-control"
                           placeholder="Buscar por item ou descrição..."
                           value="<?= htmlspecialchars($busca) ?>">
                </div>
                <button type="submit" class="btn btn-ong px-4">Buscar</button>
                <?php if ($busca): ?>
                    <a href="listar_doacoes.php" class="btn btn-outline-secondary">Limpar</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Tabela -->
    <div class="card card-ong">
        <div class="card-body p-0">
            <?php if ($doacoes->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0 tabela-doacoes">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Item</th>
                            <th width="120">Quantidade</th>
                            <th>Descrição</th>
                            <th width="140">Data</th>
                            <th width="120" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($d = $doacoes->fetch_assoc()): ?>
                        <tr>
                            <td class="text-muted"><?= $d['id'] ?></td>
                            <td><strong><?= htmlspecialchars($d['item']) ?></strong></td>
                            <td><span class="badge-qtd"><?= $d['quantidade'] ?></span></td>
                            <td class="text-muted">
                                <?= $d['descricao'] ? htmlspecialchars(mb_strimwidth($d['descricao'], 0, 80, '...')) : '<em class="text-muted">—</em>' ?>
                            </td>
                            <td class="text-muted small"><?= date('d/m/Y H:i', strtotime($d['criado_em'])) ?></td>
                            <td class="text-center">
                                <a href="?editar=<?= $d['id'] ?>#form-editar"
                                   class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="?deletar=<?= $d['id'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   title="Deletar"
                                   onclick="return confirm('Tem certeza que deseja remover esta doação?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 text-muted small">
                <?= $doacoes->num_rows ?> doação(ões) encontrada(s)
                <?= $busca ? "para \"<strong>$busca</strong>\"" : '' ?>
            </div>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox" style="font-size:3rem"></i>
                    <p class="mt-3">
                        <?= $busca ? "Nenhuma doação encontrada para \"$busca\"." : 'Nenhuma doação registrada ainda.' ?>
                    </p>
                    <?php if (!$busca): ?>
                        <a href="nova_doacao.php" class="btn btn-ong">Registrar primeira doação</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
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
