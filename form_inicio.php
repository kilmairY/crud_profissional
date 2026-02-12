<?php
session_start();
include "Views/DashController.php";

if (!$_SESSION["usuario"]) {
    header("Location: form_login.php");
    exit();
}

$dashData = DashController::dashUsuarios();
$totalUsuarios = $dashData['totalUsuarios'];
$totalAdmins = $dashData['totalAdmins'];
$totalComuns = $dashData['totalUsuarios'] - $dashData['totalAdmins'];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Sistema de Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        .header-modern {
            background-color: #fff;
            padding: 2rem 2rem;
            color: white;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 0px 30px rgba(100, 126, 234, 0.3);
        }

        .header-modern h2 {
            font-size: 2.2rem;
            font-weight: 600;
            color: #0d6efd;
            margin-bottom: 0.6rem;
        }

        .header-modern p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .sidebar.show {
            left: 0;
        }


        .hamburger {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 50px;
            height: 50px;
            z-index: 1300;
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            display: flex;
            padding: 10px 12px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            border-radius: 12px;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hamburger:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .hamburger div {
            width: 140%;
            height: 3px;
            background-color: #fff;
            /* Mudar para branco */
            border-radius: 2px;
            transition: 0.4s;
            align-items: center;
            justify-content: center;
        }

        .hamburger.open .line1 {
            transform: rotate(-45deg) translate(-8px, 11px);
        }

        .hamburger.open .line2 {
            opacity: 0;
        }

        .hamburger.open .line3 {
            transform: rotate(45deg) translate(-8px, -11px);
        }


        .sidebar {
            position: fixed;
            top: 0;
            transition: all 0.3s ease;
            height: 100vh;
            width: 260px;
            background: #fff;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
            padding: 2rem 1rem 1rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            left: -300px;
        }

        .sidebar .icon-circle {
            width: 80px;
            height: 80px;
            background-color: #e7f1ff;
            color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: transform 0.3s;
        }

        .sidebar .icon-circle:hover {
            transform: scale(1.05);
        }

        .sidebar .quick-links .btn {
            min-width: 200px;
            margin-bottom: 1rem;
        }

        .main-content {
            margin-left: 260px;
            padding: 2rem 2rem 1rem 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .botoes {
            display: block;
            justify-content: center;
            align-items: center;
            padding: 12px 20px;
            margin-bottom: 12px;
            border-radius: 10px;
            /* Adicionar bordas arredondadas */
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .botoes:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .botoes i {
            transition: transform 0.3s ease;
        }

        .botoes:hover i {
            transform: scale(1.2);
        }

        .card {
            flex: 1;
            border-radius: 15px;
            text-align: center;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            position: relative;
            border-radius: 1rem;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .card:hover::before {
            left: 100%;
        }

        .list-group-item {
            border: none;
            border-left: 4px solid #667eea;
            margin-bottom: 0.8rem;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
            border-left-color: #0068bd;
        }

        .list-group-item::before {
            content: '📌';
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* dashboard */
        .dashboard-container {
            display: flex;

        }

        .card h3 {
            margin: 0;
            font-size: 14px;
            opacity: 0.8;
        }

        .card p {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .bg-blue {
            background-color: #0d6efd;
        }

        .bg-green {
            background-color: #198754;
        }

        .bg-orange {
            background-color: #fd7e14;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                flex-direction: row;
                justify-content: space-around;
                padding: 1rem 0;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="hamburger" id="hamburgerBtn" aria-label="Abrir menu">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
    <div class="col-12 col-md-12  mb-4">


        <div class="sidebar" id="sidebarMenu">
            <div class="icon-circle shadow-sm mb-3">
                <i class="fas fa-home fa-3x"></i>
            </div>
            <div class="w-100 text-center mb-3">
                <span style="font-size:1.5rem; font-weight:bold; display:block;">Menu</span>
            </div>
            <div class="row">
                <nav class="navbar navbar-light bg-light w-100">
                    <ul class="navbar-nav w-100">
                        <div class="col-12 md-12">
                            <li class="nav-item">
                                <a href="index.php?" class="btn btn-primary shadow-sm botoes" style="position: static-center;">
                                    <i class="fas fa-users mr-2"></i> Usuarios
                                </a>
                            </li>
                        </div>
                        <div class="col-12 md-12">
                            <li class="nav-item">
                                <a class="btn btn-primary shadow-sm botoes" href="form_registro.php">
                                    <i class="fas fa-user mr-2"></i> Registrar Usuário
                                </a>
                            </li>
                        </div>
                        <div class="col-12 md-12">
                            <li class="nav-item">
                                <a class="btn btn-primary shadow-sm botoes" href="form_visualizar_carros.php">
                                    <i class="fas fa-car-side mr-2"></i> Carros
                                </a>
                            </li>
                        </div>
                        <div class="col-12 md-12">
                            <li class="nav-item">
                                <a class="btn btn-primary shadow-sm botoes" href="form_cadastro_carros.php">
                                    <i class="fas fa-car mr-2"></i> Registrar Carro
                                </a>
                            </li>
                        </div>
                        <div class="col-12 md-12">
                            <li class="nav-item">
                                <a class="btn btn-danger shadow-sm botoes" href="Views/logout.php">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Sair
                                </a>
                            </li>
                        </div>
                    </ul>
                </nav>
            </div>
            <div class="text-center mt-4 text-muted small w-100">
                &copy; <?php echo date('Y'); ?> CRUD INICIAL
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-0 p-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h2 class="font-weight-bold text-dark mb-2">Bem-vindo ao Sistema</h2>
                                <p class="text-muted mb-4">Aqui você pode ver informativos, novidades ou avisos do sistema.</p>
                            </div>
                            <?php if (isset($_SESSION['mensagem'])): ?>
                                <div class="alert alert-info">
                                    <?php
                                    echo htmlspecialchars($_SESSION['mensagem']);
                                    unset($_SESSION['mensagem']);
                                    ?>
                                </div>
                            <?php endif; ?>
                            <!-- Espaço para informativos -->
                            <div class="mb-3">
                                <h5 class="text-primary text-center">Informativos do Sistema</h5>
                                <ul class="list-group">
                                    <li class="list-group-item text-dark">Bem-vindo! Use o menu lateral para navegar.</li>
                                    <li class="list-group-item text-dark">Adicione, edite ou visualize usuários facilmente.</li>
                                    <li class="list-group-item text-dark">Fique atento a novidades nesta área!</li>
                                    <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/album/5K79FLRUCSysQnVESLcTdb?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-4">
                    <div class="dashboard-content">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-12 col-lg-12 p-0">
                                    <div class="card bg-blue shadow-lg border-0 p-4">
                                        <div class="card-body">
                                            <div class="text-center mb-4">
                                                <h3>Total de Usuários:</h3>
                                                <p><?php echo $totalUsuarios; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card bg-green shadow-lg border-0 p-4">
                                        <div class="card-body">
                                            <div class="text-center mb-4">
                                                <h3>Usuários Administradores:</h3>
                                                <p><?php echo $totalAdmins; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card bg-orange shadow-lg border-0 p-4">
                                        <div class="card-body">
                                            <div class="text-center mb-4">
                                                <h3>Usuarios Comuns:</h3>
                                                <p><?php echo $totalComuns; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-4">
                    <div class="card shadow-lg border-0 p-4">
                        <div class="card-body">
                            <h2 class="font-weight-bold text-dark mb-2">Gráfico de Usuários</h2>
                            <canvas id="grafico"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        //slidebar
        const sidebar = document.getElementById('sidebarMenu');
        const hamburger = document.getElementById('hamburgerBtn');
        hamburger.addEventListener('click', (e) => {
            hamburger.classList.toggle('open');
            e.stopPropagation();
            sidebar.classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });

        // Gráfico de usuários
        const totalAdmins = <?php echo $totalAdmins ?>;
        const totalComuns = <?php echo $totalUsuarios - $totalAdmins ?>;

        const ctx = document.getElementById('grafico').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Administradores', 'Comuns'],
                datasets: [{
                    data: [totalAdmins, totalComuns],
                    backgroundColor: ['#198754', '#fd7e14']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Distribuição de Tipos de Usuários'
                    }
                }
            },
        });
    </script>
</body>