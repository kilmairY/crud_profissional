<?php
// Recupera o token da URL para redefinição de senha (evita erro se não vier)
$token = $_GET["token"] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetar Senha</title>
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
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            color: white;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
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
        }

        a:hover {
            color: #0068bd;
            text-decoration: none;
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
                                <i class="fas fa-lock fa-2x"></i>
                            </div>
                            <h3 class="font-weight-bold text-dark">Redefinir Senha</h3>
                            <p class="text-muted small mb-4">Insira sua nova senha abaixo para recuperar o acesso.</p>
                        </div>

                        <form method="POST" action="Views/resetaracao.php">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                            <div class="mb-4">
                                <label for="Senha" class="form-label text-muted small font-weight-bold text-uppercase">Nova Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input type="password" name="senha" id="Senha" class="form-control bg-light border-start-0" placeholder="Digite a nova senha" required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 font-weight-bold shadow-sm">
                                    Atualizar Senha
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <a href="form_login.php" class="small text-muted">
                                <i class="fas fa-arrow-left mr-1"></i> Voltar para Login
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
</body>
</html>