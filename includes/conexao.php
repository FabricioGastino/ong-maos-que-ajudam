<?php
// ============================================
// includes/conexao.php
// Configuração da conexão com o banco
// ============================================

define('DB_HOST', 'localhost');     // No InfinityFree: mude para o host deles
define('DB_USER', 'root');          // No InfinityFree: seu usuário MySQL
define('DB_PASS', '');              // No InfinityFree: sua senha MySQL
define('DB_NAME', 'ong_doacoes');   // No InfinityFree: nome do banco criado lá

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="padding:20px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;border-radius:4px;margin:20px;">
        <strong>Erro de conexão:</strong> ' . $conn->connect_error . '
    </div>');
}

$conn->set_charset("utf8mb4");
?>
