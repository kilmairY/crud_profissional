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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }


        .table-hover tbody tr:hover {
            background-color: #ffffff;
            transform: scale(1.005);
            transition: 0.2s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            z-index: 10;
            position: relative;
        }

        .avatar-placeholder {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #495057;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            text-transform: uppercase;
        }

        td {
            vertical-align: middle;
        }
    </style>

</head>

<body>

    <!-- Container principal da página -->
    <div class="container py-5">
        <div class="row mb-4 align-items-center">

            <div class="col-md-6">
                <h2 class="font-weight-bold text-dark">Gerenciar Usuários</h2>
                <p class="text-muted mb-0">
                    Logado como: <strong class="text-dark"><?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?></strong>
                    <span class="mx-2">|</span>
                    <a href="Views/logout.php" class="text-danger small"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </p>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-2 align-items-center text-right">
                <a href="form_inicio.php?" class="btn btn-primary shadow-sm">
                    <i class="fas fa-home mr-2"></i> Início
                </a>
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
                <ul class="pagination my-4">
                </ul>
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