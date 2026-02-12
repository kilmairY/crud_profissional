<?php

session_start();

if (!$_SESSION["usuario"]) {
    header("Location: form_login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="Arquivos/responsive.css">

    <style>
        body {
            background: linear-gradient(to bottom, #f4f6f9 0%, #e9ecef 100%);
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            border-radius: 1.5rem;
            border: none;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .form-control,
        .form-select {
            border-radius: 5px;
            border: 2px solid #e9ecef;
            padding: 5px 7.5px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .input-group-text {
            border-radius: 5px 0 0 5px;
            border: 2px solid #e9ecef;
            border-right: none;
            background-color: #f8f9fa;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .input-group:focus-within .input-group-text {
            border-color: #667eea;
            background: #f0f4ff;
            color: #667eea;
        }

        .input-group .form-control,
        .input-group .form-select {
            border-left: none;
            border-radius: 0 10px 10px 0;
            flex: 1;
        }

        .form-select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 15px;
            background-position: right 10px center;
        }

        select.form-control,
        select.form-select {
            min-width: 200px;
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
            padding-right: 35px;
        }

        select.form-control option,
        select.form-select option {
            padding: 10px;
            white-space: normal;
            overflow-wrap: break-word;
        }

        .fa-users-cog {
            color: #667eea;
        }

        .fa-user {
            color: #667eea;
        }

        .fa-birthday-cake {
            color: #667eea;
        }

        .fa-envelope {
            color: #667eea;
        }

        .fa-lock {
            color: #dc3545;
        }

        .fa-user-plus {
            color: #667eea;
        }

        a {
            color: #667eea;
            transition: all 0.3s ease;
        }

        a:hover {
            color: #0068bd;
            text-decoration: none;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">

                <!-- card branco em volta da label -->
                <div class="card shadow-lg border-0">
                    <div class="row-6">
                        <?php if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]) { ?>
                            <div class="col-12 d-flex align-items-center justify-content-end p-3">
                                <a href="form_inicio.php?" class="btn btn-primary shadow-sm">
                                    <i class="fas fa-home me-2 font-underline"></i><u>Início</u> 
                                </a>
                            </div>
                        <?php } ?>
                    </div>
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
                                <i class="fas fa-check-circle mr-2"></i>
                                <div>Registro realizado com sucesso! <a href="form_login.php" class="font-weight-bold text-success">Faça login.</a></div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['erro_email']) && $_GET['erro_email'] == 1): ?>
                            <div class="alert alert-danger d-flex align-items-center small" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>Ocorreu um erro ao enviar o e-mail de confirmação</div>
                            </div>
                        <?php endif; ?>


                        <form method="POST" action="Views/RegistrarAcao.php?">

                            <!--Nome -->
                            <div class="mb-3">
                                <label class="form-label text-muted small font-weight-bold text-uppercase">Nome Completo</label>
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
                                    <label class="form-label text-muted small font-weight-bold text-uppercase">Idade</label>
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
                                    <label class="form-label text-muted small font-weight-bold text-uppercase">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email"
                                            name="Email" class="form-control"
                                            placeholder="seu@email.com"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <!-- tipo de usuario -->
                            <?php if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['tipo_usuario']) && $_SESSION['usuario']['tipo_usuario'] === 'admin'): ?>
                                <div class="mb-4">
                                    <label class="form-label text-muted fw-bold text-uppercase">Tipo de Usuário</label>
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

                            <!-- botão registrar -->
                            <div class="row-6 text-center mb-4">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                        Registrar-se
                                    </button>
                                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
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