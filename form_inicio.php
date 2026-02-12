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
    <link rel="stylesheet" href="Assets/CSS/form_inicio.css">
    
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