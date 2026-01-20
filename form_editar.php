<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: form_login.php');
    exit();
}
require_once __DIR__ . '/Dados/db.php';
require_once __DIR__ . '/Views/UsuarioController.php';
$usuario = UsuarioController::obterUsuario($_GET['id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 1rem;
        }

        /* Ajuste para inputs ficarem na mesma altura dos ícones */
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        
        .form-control {
            border-left: none;
        }

        /* Foco no input ilumina a borda do ícone também */
        .form-control:focus + .input-group-text, 
        .form-control:focus {
            box-shadow: none;
            border-color: #86b7fe; 
        }
        /* Pequeno truque para borda do grupo quando focado */
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #86b7fe;
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
                            <h3 class="fw-bold text-dark mb-0">
                                <i class="fas fa-user-edit text-primary me-2"></i>Editar Usuário
                            </h3>
                            <a href="index.php" class="btn btn-outline-secondary btn-sm shadow-sm">
                                <i class="fas fa-arrow-left me-1"></i> Voltar
                            </a>
                        </div>
                        
                        <?php if (isset($_GET['erro'])): ?>
                            <div class="alert alert-danger d-flex align-items-center shadow-sm" role="alert">
                                <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                                <div>
                                    <strong>Erro:</strong> <?php echo htmlspecialchars($_GET['erro']); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="Views/update.php?id=<?php echo $usuario['id']; ?>">
                            
                            <div class="mb-3">
                                <label for="nome" class="form-label text-muted small fw-bold text-uppercase">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text text-muted"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nome" id="nome" class="form-control" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="idade" class="form-label text-muted small fw-bold text-uppercase">Idade</label>
                                    <div class="input-group">
                                        <span class="input-group-text text-muted"><i class="fas fa-calendar-day"></i></span>
                                        <input type="number" name="idade" id="idade" class="form-control" value="<?php echo htmlspecialchars($usuario['idade']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-8 mb-4">
                                    <label for="email" class="form-label text-muted small fw-bold text-uppercase">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text text-muted"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm fw-bold">
                                    <i class="fas fa-save me-2"></i>Atualizar Dados
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>