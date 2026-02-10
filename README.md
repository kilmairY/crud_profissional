# CRUD Profissional

Um sistema web simples para cadastro, gerenciamento e autenticação de usuários, desenvolvido em PHP com PDO e Bootstrap.

## Funcionalidades
- Cadastro, login e logout de usuários
- Recuperação e redefinição de senha
- Listagem, busca e paginação de usuários
- Controle de acesso por tipo de usuário (admin e comum)
- Painel de estatísticas (total de usuários, admins, novos no mês)

## Tecnologias Utilizadas
- PHP (com PDO)
- MySQL
- Bootstrap 5
- JavaScript (fetch API)
- PHPMailer (para envio de e-mails)

## Estrutura Principal
- `index.php` — Tela principal de usuários
- `form_login.php`, `form_registro.php` — Autenticação e cadastro
- `Views/` — Lógica de controle e ações
- `Dados/` — Conexão e manipulação de dados
- `Components/` — Componentes de interface (ex: GridAdmin)

## Como rodar
1. Clone o projeto e configure o banco de dados MySQL
2. Ajuste as credenciais em `Dados/db.php`
3. Acesse via navegador pelo XAMPP ou similar

---
Projeto para fins didáticos e profissionais.
