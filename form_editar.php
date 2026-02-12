<?php
session_start();
include("Views/VerificaAdmin.php");

if (!isset($_SESSION['usuario'])) {
    header('Location: form_login.php');
    exit();
}
require_once __DIR__ . '/Dados/db.php';
require_once __DIR__ . '/Views/UsuarioController.php';
$usuario = UsuarioController::obterUsuario($_GET['Id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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
            padding: 40px 0;
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

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
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
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .input-group:focus-within .input-group-text {
            border-color: #667eea;
            background: #f0f4ff;
            color: #667eea;
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
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card shadow border-0">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="font-weight-bold text-dark mb-0">
                                <i class="fas fa-user-edit text-primary mr-2"></i>Editar Usuário
                            </h3>
                            <a href="index.php" class="btn btn-outline-secondary btn-sm shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Voltar
                            </a>
                        </div>s

                        <?php if (isset($_GET['erro'])): ?>
                            <div class="alert alert-danger d-flex align-items-center shadow-sm" role="alert">
                                <i class="fas fa-exclamation-triangle mr-3 fs-4"></i>
                                <div>
                                    <strong>Erro:</strong> <?php echo htmlspecialchars($_GET['erro']); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="Views/update.php?id=<?php echo $usuario['Id']; ?>">

                            <div class="mb-3">
                                <label for="Nome" class="form-label text-muted small font-weight-bold text-uppercase">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text text-muted"><i class="fas fa-user"></i></span>
                                    <input type="text" name="Nome" id="Nome" class="form-control" value="<?php echo htmlspecialchars($usuario['Nome']); ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="Idade" class="form-label text-muted small font-weight-bold text-uppercase">Idade</label>
                                    <div class="input-group">
                                        <span class="input-group-text text-muted"><i class="fas fa-calendar-day"></i></span>
                                        <input type="number" name="Idade" id="Idade" class="form-control" value="<?php echo htmlspecialchars($usuario['Idade']); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-8 mb-4">
                                    <label for="Email" class="form-label text-muted small font-weight-bold text-uppercase">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text text-muted"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="Email" id="Email" class="form-control" value="<?php echo htmlspecialchars($usuario['Email']); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm font-weight-bold">
                                    <i class="fas fa-save mr-2"></i>Atualizar Dados
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>