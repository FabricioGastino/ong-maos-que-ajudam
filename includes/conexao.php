<?php


define('DB_HOST', 'localhost');
define('DB_USER', 'root');          
define('DB_PASS', '');            
define('DB_NAME', 'ong_doacoes');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="padding:20px;background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;border-radius:4px;margin:20px;">
        <strong>Erro de conexão:</strong> ' . $conn->connect_error . '
    </div>');
}

$conn->set_charset("utf8mb4");
?>
