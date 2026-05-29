<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit();
}

require_once 'includes/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                header('Location: dashboard.php');
                exit();
            } else {
                $erro = 'Senha incorreta.';
            }
        } else {
            $erro = 'E-mail não encontrado.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - ONG Mãos que Ajudam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
</head>
<body>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="card auth-card">
                    <!-- Header -->
                    <div class="auth-header">
                        <div class="logo-icon"><i class="bi bi-heart-fill"></i></div>
                        <h4 class="fw-bold mb-1">Bem-vindo de volta!</h4>
                        <p class="mb-0 opacity-75">ONG Mãos que Ajudam</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4">

                        <?php if ($erro): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($erro) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['logout'])): ?>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>Você saiu com sucesso.
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control"
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                           placeholder="seu@email.com" required autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="senha" class="form-control"
                                           placeholder="Sua senha" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-ong w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                            </button>
                        </form>

                        <!-- Dica de acesso rápido para apresentação -->
                        <div class="alert alert-light border mt-3 small">
                            <strong>Acesso de teste:</strong><br>
                            Email: admin@ong.com<br>
                            Senha: 123456
                        </div>

                        <hr class="my-3">
                        <p class="text-center text-muted mb-0">
                            Não tem conta? <a href="cadastro.php" style="color: var(--verde); font-weight:600;">Cadastrar</a>
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
