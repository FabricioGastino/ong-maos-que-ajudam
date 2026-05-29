# 🤝 ONG Mãos que Ajudam — Sistema de Gerenciamento de Doações

Sistema web desenvolvido para controle de doações recebidas por uma ONG. Projeto acadêmico com PHP, MySQL e Bootstrap.

---

## 📋 Funcionalidades

- ✅ Página inicial institucional
- ✅ Cadastro de usuários (com senha criptografada)
- ✅ Login com autenticação por sessão
- ✅ Dashboard com estatísticas gerais
- ✅ CRUD completo de doações (Criar, Listar, Editar, Deletar)
- ✅ Busca de doações
- ✅ Interface responsiva com Bootstrap 5

---

## 🛠️ Tecnologias

| Camada | Tecnologia |
|--------|-----------|
| Front-end | HTML5, CSS3, Bootstrap 5, Bootstrap Icons |
| Back-end | PHP 8+ |
| Banco de dados | MySQL |
| Hospedagem | InfinityFree |

---

## 📁 Estrutura do Projeto

```
ong-system/
├── index.php           # Página inicial
├── login.php           # Login
├── cadastro.php        # Cadastro de usuário
├── dashboard.php       # Painel de controle
├── nova_doacao.php     # Formulário de nova doação
├── listar_doacoes.php  # Lista com editar/deletar
├── logout.php          # Encerrar sessão
├── css/
│   └── estilo.css      # Estilos personalizados
├── includes/
│   ├── conexao.php     # Conexão com o banco
│   └── auth.php        # Proteção de páginas
└── database/
    └── banco.sql       # Script do banco de dados
```

---

## 🗄️ Banco de Dados

```sql
-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de doações
CREATE TABLE doacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    item VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL,
    descricao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);
```

---

## 🚀 Como Rodar Localmente (XAMPP)

1. **Instale o XAMPP** → [https://www.apachefriends.org](https://www.apachefriends.org)
2. Copie a pasta do projeto para `C:\xampp\htdocs\ong-system`
3. Inicie o **Apache** e o **MySQL** no XAMPP Control Panel
4. Acesse o **phpMyAdmin**: `http://localhost/phpmyadmin`
5. Crie um banco chamado `ong_doacoes`
6. Importe o arquivo `database/banco.sql`
7. Acesse: `http://localhost/ong-system`

**Login de teste:**
- Email: `admin@ong.com`
- Senha: `123456`

---

## 🌐 Como Hospedar no InfinityFree

1. Crie uma conta em [https://infinityfree.com](https://infinityfree.com)
2. Crie um novo site no painel
3. Acesse o **MySQL Database** e crie um banco
4. Importe o `banco.sql` via phpMyAdmin do InfinityFree
5. Edite `includes/conexao.php` com os dados fornecidos pelo InfinityFree:
   ```php
   define('DB_HOST', 'sql_host_aqui');
   define('DB_USER', 'usuario_aqui');
   define('DB_PASS', 'senha_aqui');
   define('DB_NAME', 'nome_banco_aqui');
   ```
6. Envie os arquivos via **File Manager** ou **FTP (FileZilla)**
7. Acesse pelo domínio fornecido

---

## 👨‍💻 Desenvolvido por

Projeto acadêmico — Tecnologia em Análise e Desenvolvimento de Sistemas

---

## 📄 Licença

Projeto de uso educacional.
