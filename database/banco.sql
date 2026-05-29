-- ============================================
-- Sistema de Cadastro para ONG
-- Banco de Dados
-- ============================================

CREATE DATABASE IF NOT EXISTS ong_doacoes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE ong_doacoes;

-- Tabela de Usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Doações
CREATE TABLE IF NOT EXISTS doacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    item VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL,
    descricao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Usuário de teste (senha: 123456)
INSERT INTO usuarios (nome, email, senha) VALUES
('Admin ONG', 'admin@ong.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
