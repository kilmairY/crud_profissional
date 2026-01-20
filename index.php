<?php
session_start();
require_once __DIR__ . '/Dados/db.php';
require_once __DIR__ . '/Views/UsuarioController.php';

// Verificar se usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: form_login.php');
    exit();
}

$usuarios = UsuarioController::index();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Profissional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Define a cor de fundo da página*/
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* --- EFEITO MÁGICO DO HOVER --- */
        /* Quando o mouse passa por cima de uma linha (tr) da tabela: */
        .table-hover tbody tr:hover {
            background-color: #ffffff;
            /* Garante que o fundo fique branco puro */
            transform: scale(1.005);
            /* Aumenta levemente o tamanho da linha (zoom in) */
            transition: 0.2s;
            /* Faz a animação durar 0.2 segundos (suave) */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            /* Cria uma sombra suave embaixo */
            z-index: 10;
            /* Traz a linha para "frente" dos outros elementos */
            position: relative;
            /* Necessário para o z-index funcionar */
        }

        /* --- ESTILO DO AVATAR (BOLINHA) --- */
        .avatar-placeholder {
            width: 45px;
            /* Tamanho fixo */
            height: 45px;
            /* Tamanho fixo */
            border-radius: 50%;
            /* Transforma o quadrado em um círculo perfeito */
            background-color: #e9ecef;
            /* Fundo cinza claro */
            color: #495057;
            /* Cor da letra (iniciais) cinza escuro */

            /* Centraliza as letras perfeitamente no meio da bolinha */
            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: bold;
            font-size: 1.1rem;
            text-transform: uppercase;
            /* Garante que as letras sejam maiúsculas */
        }

        /* Garante que todo conteúdo das células da tabela fique centralizado verticalmente */
        td {
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="row mb-4 align-items-center">

            <div class="col-md-6">
                <h2 class="fw-bold text-dark">Gerenciar Usuários</h2>
                <p class="text-muted mb-0">
                    Logado como: <strong class="text-dark"><?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?></strong>
                    <span class="mx-2">|</span>
                    <a href="Views/logout.php" class="text-danger text-decoration-none small"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </p>
            </div>

            <div class="col-md-6 text-end">
                <a href="form_registro.php" class="btn btn-primary shadow-sm px-4">
                    <i class="fas fa-plus me-2"></i>Novo Usuário
                </a>
            </div>
        </div>

        <div class="card shadow border-0 mb-5">
            <div class="card-body p-0">

                <table class="table table-hover table-borderless align-middle mb-0">

                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">Usuário (Nome / Email)</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">ID</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Idade</th>
                            <th class="text-end pe-4 py-3 text-uppercase text-muted small fw-bold">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">

                                        <div class="avatar-placeholder me-3 shadow-sm">
                                            <?php
                                            echo htmlspecialchars(substr($usuario['nome'], 0, 2));
                                            ?>
                                        </div>

                                        <div>
                                            <div class="fw-bold text-dark"><?php echo htmlspecialchars($usuario['nome']); ?></div>
                                            <div class="small text-muted"><?php echo htmlspecialchars($usuario['email']); ?></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-muted fw-bold small">
                                    #<?php echo htmlspecialchars($usuario['id']); ?>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?php echo htmlspecialchars($usuario['idade']); ?> anos
                                    </span>
                                </td>

                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                            <li>
                                                <a class="dropdown-item small" href="form_editar.php?id=<?php echo $usuario['id']; ?>">
                                                    <i class="fas fa-edit me-2 text-primary"></i> Editar
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a class="dropdown-item small text-danger" href="Views/deletar.php?id=<?php echo $usuario['id']; ?>" onclick="return confirm('Tem certeza que deseja deletar?');">
                                                    <i class="fas fa-trash-alt me-2"></i> Deletar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($usuarios)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-users mb-3" style="font-size: 2rem; opacity: 0.3;"></i><br>
                                    Nenhum usuário encontrado.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

