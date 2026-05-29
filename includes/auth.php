<?php
// ============================================
// includes/auth.php
// Verifica se o usuário está logado
// ============================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
?>
