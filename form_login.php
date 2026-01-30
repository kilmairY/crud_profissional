<?php
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            /* Fundo cinza claro padrão */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            /* Altura total da tela */
            display: flex;
            align-items: center;
            /* Centraliza verticalmente */
            justify-content: center;
            /* Centraliza horizontalmente */
        }

        .card {
            border-radius: 1rem;
            /* Bordas arredondadas */
        }

        /* Estilo do Círculo do Ícone */
        .icon-circle {
            width: 80px;
            height: 80px;
            background-color: #e7f1ff;
            /* Azul bem clarinho */
            color: #0d6efd;
            /* Azul primário */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            transition: transform 0.3s;
        }

        /* Pequena animação ao passar o mouse no card */
        .card:hover .icon-circle {
            transform: scale(1.05);
        }

        .a {
            text-decoration: none;
            align-items: center;
            justify-content: end;
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
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>Email ou senha inválidos.</div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['cadastro_sucesso']) && $_GET['cadastro_sucesso'] == 1): ?>
                            <div class="alert alert-success d-flex align-items-center small" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>Cadastro realizado com sucesso! Por favor, verifique seu e-mail para confirmar sua conta.</div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['erro_verificacao']) && $_GET['erro_verificacao'] == 1): ?>
                            <div class="alert alert-danger d-flex align-items-center small d-flex flex-column" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <p class="small text-center mb-1">Sua conta ainda não foi verificada.</p>
                                </div>
                                <a href="Views/ReenviarVerificacao.php?email=<?php echo urlencode($_GET['email']); ?>" class="small text-decoration-none text-muted"><br>Reenviar e-mail de verificação</br></a>
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
                                <label for="email" class="form-label text-muted small fw-bold text-uppercase">Email</label>
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

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                    Entrar
                                </button>
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

                <div class="text-center mt-3 text-muted small">
                    &copy; <?php echo date('Y'); ?> CRUD INICIAL
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>