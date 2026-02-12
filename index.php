<?php

session_start();
require_once __DIR__ . '/Dados/db.php';
require_once __DIR__ . '/Views/UsuarioController.php';


if (!isset($_SESSION['usuario'])) {
    header('Location: form_login.php');
    exit();
}

$dados = UsuarioController::index();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Profissional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #f4f6f9 0%, #e9ecef 100%);
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #0c007c 100%);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .header-section h2 {
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .header-section p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
        }

        .header-section a {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: underline;
        }

        .header-section a:hover {
            color: #fff;
            text-decoration: none;
            transform: translateX(3px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #21028f 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #0c038f 100%);
            border-color: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .table-hover tbody tr {
            transition: all 0.3s ease;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            z-index: 10;
            position: relative;
        }

        .table thead th {
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        .table tbody td {
            border: none;
            padding: 1rem 0.75rem;
        }

        .avatar-placeholder {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #00116e 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
        }

        td {
            vertical-align: middle;
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 3px;
            border: none;
            color: #667eea;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            color: white;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            border: none;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
        }

        .btn-sm {
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-sm:hover {
            transform: translateY(-2px);
        }

        .btn-light {
            background: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #667eea;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .botoes {
            position: relative;
            overflow: hidden;
        }

        .botoes::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .botoes:hover::after {
            width: 300px;
            height: 300px;
        }

        .btn-light:hover {
            background: white;
            color: #0068bd;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .dropdown-menu {
            border-radius: 12px;
            padding: 0.5rem;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }

        .border-bottom {
            border-bottom: 2px solid #f0f0f0 !important;
        }
    </style>

</head>

<body>

    <!-- Container principal da página -->
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="header-section">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2"><i class="fas fa-users-cog mr-2"></i>Gerenciar Usuários</h2>
                            <p class="mb-0">
                                Logado como: <strong><?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?></strong>
                                <span class="mx-2">|</span>
                                <a href="Views/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
                            </p>
                        </div>
                        <div class="col-md-4 text-right mt-3 mt-md-0">
                            <a href="form_inicio.php" class="btn btn-primary shadow-sm text-color-dark">
                                <i class="fas fa-home mr-2"></i>Início
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- quadro branco -->
        <div class="card shadow border-0 mb-5">
            <div class="card-body p-0">
                <div class="row align-items-center p-4 border-bottom">
                    <div class="col-md-6 text-start p-4">
                        <form class="d-flex" role="search">
                            <input class="form-control mr-2" type="search" id="busca" placeholder="Digite o nome ou email" style="padding: 10px; width:300px">
                        </form>
                    </div>
                    <div class="col-md-4 text-end">
                    </div>
                    <!-- botão de novo usuário -->
                    <div class="col-md-2 text-right">
                        <a href="form_registro.php?" class="btn btn-outline-primary shadow-sm">
                            <i class="fas fa-plus mr-2"></i>Novo Usuário
                        </a>
                    </div>
                    <table class="table table-hover table-borderless align-middle mb-0">

                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="pl-4 py-3 text-uppercase text-muted small font-weight-bold">Usuário (Nome / Email)</th>
                                <th class="py-3 text-uppercase text-muted small font-weight-bold">ID</th>
                                <th class="py-3 text-uppercase text-muted small font-weight-bold">Idade</th>
                                <th class="text-right pr-4 py-3 text-uppercase text-muted small font-weight-bold">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="resultado_busca">

                        </tbody>
                    </table>
                </div>
            </div>
            <nav aria-label="navegação de usuarios"
            <div class="card-footer d-flex justify-content-end bg-white border-0">
                    <ul class="pagination my-4">
                    </ul>
                </div>
            </nav>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <script>
            const inputBusca = document.getElementById('busca');
            const resultadoBusca = document.getElementById('resultado_busca');
            const buscarUsuarios = async (termo, pagina) => {
                const response = await fetch('Views/Buscar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        termo: termo,
                        paginaAtual: pagina
                    }),
                });

                const usuarios = await response.json();
                atualizarTabela(usuarios.resultados);
                paginacao(usuarios.paginas, usuarios.pagina_atual);
            };

            const paginacao = (totalPaginas, paginaAtual) => {
                const paginacaoContainer = document.querySelector('.pagination');
                paginacaoContainer.innerHTML = '';

                for (let i = 1; i <= totalPaginas; i++) {
                    let paginaAtualHtml = i === paginaAtual ? 'active' : '';
                    paginacaoContainer.innerHTML += `
                <li class="page-item ${paginaAtualHtml}">
                    <button class="page-link btn-pagina" data-pagina="${i}">
                        ${i}
                    </button>
                </li>
                `;
                }

                const btnPaginas = document.querySelectorAll('.btn-pagina');
                btnPaginas.forEach(botao => {
                    botao.addEventListener('click', function(e) {
                        let termo = inputBusca.value;
                        let pagina = botao.getAttribute('data-pagina');
                        buscarUsuarios(termo, pagina);
                    });
                });
            };

            const atualizarTabela = (usuarios) => {
                resultadoBusca.innerHTML = usuarios;
            };

            let timeout = null;


            inputBusca.addEventListener('input', (e) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const termo = e.target.value;
                    buscarUsuarios(termo, 1);
                }, 500); // Espera
            });

            buscarUsuarios('', 1);
        </script>
</body>