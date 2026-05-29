<?php
// cadastro.php - Cadastro de Usuário
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit();
}

require_once 'includes/conexao.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif ($senha !== $confirmar) {
        $erro = 'As senhas não coincidem.';
    } else {
        // Verificar se email já existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $erro = 'Este e-mail já está cadastrado.';
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt2->bind_param("sss", $nome, $email, $hash);
            if ($stmt2->execute()) {
                $sucesso = 'Conta criada com sucesso! Faça login para continuar.';
            } else {
                $erro = 'Erro ao criar conta. Tente novamente.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro - ONG Mãos que Ajudam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
</head>
<body>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card auth-card">
                    <!-- Header -->
                    <div class="auth-header">
                        <div class="logo-icon"><i class="bi bi-person-plus-fill"></i></div>
                        <h4 class="fw-bold mb-1">Criar Conta</h4>
                        <p class="mb-0 opacity-75">Junte-se à nossa missão</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4">

                        <?php if ($erro): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($erro) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($sucesso): ?>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i><?= $sucesso ?>
                                <div class="mt-2">
                                    <a href="login.php" class="btn btn-ong btn-sm">Fazer Login</a>
                                </div>
                            </div>
                        <?php else: ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Nome Completo *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nome" class="form-control"
                                           value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                                           placeholder="Seu nome completo" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">E-mail *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control"
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                           placeholder="seu@email.com" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Senha *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="senha" class="form-control"
                                           placeholder="Mínimo 6 caracteres" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Confirmar Senha *</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="confirmar" class="form-control"
                                           placeholder="Repita a senha" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-ong w-100">
                                <i class="bi bi-person-check me-2"></i>Criar Minha Conta
                            </button>
                        </form>

                        <?php endif; ?>

                        <hr class="my-4">
                        <p class="text-center text-muted mb-0">
                            Já tem conta? <a href="login.php" style="color: var(--verde); font-weight:600;">Fazer Login</a>
                        </p>
                        <p class="text-center mt-2 mb-0">
                            <a href="index.php" class="text-muted small"><i class="bi bi-arrow-left me-1"></i>Voltar ao início</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
