<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci a Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9; /* Fundo padrão do sistema */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh; 
            display: flex;
            align-items: center; /* vertical */
            justify-content: center; /* horizontal */
        }

        .card {
            border-radius: 1rem;
        }

        /* Círculo do ícone */
        .icon-circle {
            width: 70px;
            height: 70px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            color: #0d6efd;
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
                                <i class="fas fa-envelope-open-text fa-2x"></i>
                            </div>
                            <h3 class="fw-bold text-dark">Esqueceu a senha?</h3>
                            <p class="text-muted small mb-4">
                                Não se preocupe. Digite seu email abaixo e enviaremos um link de recuperação.
                            </p>
                        </div>

                        <form method="POST" action="Views/esqueci_acao.php">
                            
                            <div class="mb-4">
                                <label for="email" class="form-label text-muted small fw-bold text-uppercase">Email Cadastrado</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fas fa-at"></i>
                                    </span>
                                    <input type="email" name="email" id="email" class="form-control bg-light border-start-0" placeholder="exemplo@email.com" required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                    Enviar Link de Recuperação
                                </button>
                            </div>

                        </form>

                        <div class="text-center mt-4">
                            <a href="form_login.php" class="text-decoration-none small text-muted">
                                <i class="fas fa-arrow-left me-1"></i> Voltar para Login
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