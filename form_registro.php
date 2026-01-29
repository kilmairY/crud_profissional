<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Centraliza verticalmente */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .card {
            border-radius: 1rem;
        }

        /* ícones dentro dos inputs */
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: #6c757d;
        }

        .form-control {
            border-left: none;
        }

        /* Efeito de foco azul */
        .form-control:focus+.input-group-text,
        .form-control:focus,
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            box-shadow: none;
            border-color: #86b7fe;
            color: #495057;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">

                <!-- card branco em volta da label -->
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-user-plus fa-3x text-primary"></i>
                            </div>
                            <h3 class="fw-bold text-dark">Criar Conta</h3>
                            <p class="text-muted small">Preencha os dados abaixo para começar.</p>
                        </div>

                        <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
                            <div class="alert alert-danger d-flex align-items-center small" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div><strong>Ops!</strong> Este email já está cadastrado.</div>
                            </div>

                        <?php elseif (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
                            <div class="alert alert-success d-flex align-items-center small" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>Registro realizado com sucesso! <a href="form_login.php" class="fw-bold text-success">Faça login.</a></div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['erro_email'])&& $_GET['erro_email'] == 1): ?>
                            <div class="alert alert-danger d-flex align-items-center small" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>Ocorreu um erro ao enviar o e-mail de confirmação</div>
                            </div>
                        <?php endif; ?>


                        <form method="POST" action="Views/RegistrarAcao.php?">

                            <!--Nome -->
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text"
                                        name="Nome"
                                        class="form-control"
                                        placeholder="Seu nome"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <!--idade -->
                                <div class="col-4 mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Idade</label>
                                    <div class="input-group">
                                        <span class="input-group-text px-2"><i class="fas fa-birthday-cake"></i></span>
                                        <input type="number"
                                            name="Idade"
                                            class="form-control px-2 text-center"
                                            placeholder="18+"
                                            min="18"
                                            max="120"
                                            required
                                            oninput="validarIdade(this)">
                                    </div>
                                    <div class="form-text text-danger d-none" id="erroIdade" style="font-size: 0.75rem;">
                                        Idade mínima: 18 anos
                                    </div>
                                </div>
                                <!--email -->
                                <div class="col-8 mb-3">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email"
                                            name="Email" class="form-control"
                                            placeholder="seu@email.com"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <!-- senha  -->
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password"
                                        name="Senha"    
                                        class="form-control"
                                        placeholder="Crie uma senha forte"
                                        required>
                                </div>
                            </div>

                            <!-- tipo de usuario -->
                             <?php if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['tipo_usuario']) && $_SESSION['usuario']['tipo_usuario'] === 'admin'): ?>
                                    <div class="mb-4">
                                        <label class="form-label text-muted small fw-bold text-uppercase">Tipo de Usuário</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-users-cog"></i></span>
                                            <select name="Tipo_Usuario" class="form-select" required>
                                                <option value="" disabled selected>Selecione o tipo de usuário</option>
                                                <option value="admin">Administrador</option>
                                                <option value="usuario">Usuário Comum</option>
                                            </select>
                                        </div>
                                    </div>
                            <?php else: ?>
                                    <input type="hidden" name="Tipo_Usuario" value="usuario">
                            <?php endif; ?>
                            <!-- botão registrar -->
                             
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                    Registrar-se
                                </button>
                            </div>

                        </form>
                        <!-- link para login (parte de baixo da pagina) -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="small text-muted mb-0">Já tem uma conta?</p>
                            <a href="form_login.php" class="text-decoration-none fw-bold">
                                Fazer Login
                            </a>
                        </div>

                    </div>
                </div>

                <div class="text-center mt-3 text-muted small">
                    &copy; <?php echo date('Y'); ?> CRUD INICIAL
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validarIdade(input) {
            const idade = parseInt(input.value);
            const erroIdade = document.getElementById('erroIdade');

            if (idade < 18) {
                erroIdade.classList.remove('d-none');
                input.setCustomValidity('Idade mínima: 18 anos');
            } else {
                erroIdade.classList.add('d-none');
                input.setCustomValidity('');
            }
        }
    </script>
</body>

</html>