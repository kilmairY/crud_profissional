<?php
// Destroi sessão
if (isset($_GET['Sessao']) && $_GET['Sessao'] == 1) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            border-radius: 1.5rem;
            border: none;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
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

        .icon-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .card:hover .icon-circle {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 2px solid #e9ecef;
            border-right: none;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .input-group:focus-within .input-group-text {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        a {
            color: #667eea;
            transition: all 0.3s ease;
            font-weight: 500;
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
            <div class="col-md-5 col-lg-4">

                <div class="card shadow-lg border-0 p-3">
                    <div class="card-body">

                        <div class="text-center">
                            <div class="icon-circle shadow-sm">
                                <i class="fas fa-user-circle fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-4">Bem-vindo</h3>
                        </div>

                        <?php if (isset($_GET['erro'])): ?>
                            <div class="alert alert-danger d-flex align-items-center small" role="alert">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <div>Email ou senha inválidos.</div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['cadastro_sucesso']) && $_GET['cadastro_sucesso'] == 1): ?>
                            <div class="alert alert-success d-flex align-items-center small" role="alert">
                                <i class="fas fa-check-circle mr-2"></i>
                                <div>Cadastro realizado com sucesso! Por favor, verifique seu e-mail para confirmar sua conta.</div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['erro_verificacao']) && $_GET['erro_verificacao'] == 1): ?>
                            <div class="alert alert-danger d-flex align-items-center small d-flex flex-column" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <p class="small text-center mb-1">Sua conta ainda não foi verificada.</p>
                                </div>
                                <a href="Views/ReenviarVerificacao.php?email=<?php echo urlencode($_GET['email']); ?>" class="small text-muted"><br>Reenviar e-mail de verificação</br></a>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['erro_reenvio']) && $_GET['erro_reenvio'] == 1): ?>
                            <div class="alert alert-danger d-flex align-items-center small" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>Ocorreu um erro ao reenviar o e-mail de verificação.</div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['recuperacao_enviada']) && $_GET['recuperacao_enviada'] == 0): ?>
                            <div class="alert alert-danger d-flex align-items-center small" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>Email não encontrado no sistema.</div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['reenviado']) && $_GET['reenviado'] == 1): ?>
                            <div class="alert alert-success d-flex align-items-center small" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>E-mail de verificação reenviado com sucesso.</div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['email_enviado']) && $_GET['email_enviado'] == 1): ?>
                            <div class="alert alert-success d-flex align-items-center small" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>E-mail de recuperação enviado com sucesso.</div>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="Views/LoginAcao.php">

                            <div class="mb-3">
                                <label for="email" class="form-label text-muted small font-weight-bold text-uppercase">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="Email" id="Email" class="form-control bg-light border-start-0" placeholder="Digite seu email" required>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="Senha" class="form-label text-muted small fw-bold text-uppercase">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" name="Senha" id="Senha" class="form-control bg-light border-start-0" placeholder="Sua senha" required>
                                </div>
                            </div>

                            <div class="text-end mb-4">
                                <a href="form_esqueci_senha.php" class="small text-decoration-none text-muted">
                                    Esqueceu a senha?
                                </a>
                            </div>

                            <div class="row-6 text-center mb-4">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                    Entrar
                                </button>
                            </div>
                        </div>

                        </form>

                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="small text-muted mb-0">Não tem uma conta?</p>
                            <a href="form_registro.php?contafora=1" class="text-decoration-none fw-bold">
                                Criar nova conta
                            </a>
                        </div>

                    </div>
                </div>

                <div class="text-center mt-3 small" style="color: rgba(255, 255, 255, 0.9);">
                    &copy; <?php echo date('Y'); ?> CRUD INICIAL
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>