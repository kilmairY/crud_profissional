<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Sistema de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .sidebar.show {
            left: 0;
        }

        .hamburger {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 45px;
            height: 40px;
            z-index: 1300;
            background-color: #fff;
            display: flex;
            padding: 10px 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }

        .hamburger div {
            width: 140%;
            height: 3px;
            background-color: #333;
            border-radius: 2px;
            transition: 0.4s;   
            align-items: center;
            justify-content: center;
        }


        .hamburger.open .line1 {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .hamburger.open .line2 {
            opacity: 0;
        }

        .hamburger.open .line3 {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
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

        .card {
            border-radius: 1rem;
        }

        .botoes{
            display: block;
            justify-content: center;
            align-items: center;
            padding: 10px 15px;
            margin-bottom: 10px;
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
    <div class="sidebar" id="sidebarMenu">
        <div class="icon-circle shadow-sm mb-3">
            <i class="fas fa-home fa-3x"></i>
        </div>
        <div class="w-100 text-center mb-3">
            <span style="font-size:1.5rem; font-weight:bold; display:block;">Menu</span>
        </div>
        <nav class="navbar navbar-light bg-light w-100">
            <ul class="navbar-nav w-100">
                <li class="nav-item">
                    <a href="index.php?" class="btn btn-primary shadow-sm botoes" style="position: static-center;">
                            <i class="fas fa-users me-2"></i>Usuarios
                        </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary shadow-sm botoes" href="form_registro.php">
                        <i class="fas fa-user me-2"></i>Registrar Usuário
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-danger shadow-sm botoes" href="Views/logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i>Sair
                    </a>
                </li>
            </ul>
        </nav>
        <div class="text-center mt-4 text-muted small w-100">
            &copy; <?php echo date('Y'); ?> CRUD INICIAL
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="card shadow-lg border-0 p-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold text-dark mb-2">Bem-vindo ao Sistema</h2>
                                <p class="text-muted mb-4">Aqui você pode ver informativos, novidades ou avisos do sistema.</p>
                            </div>
                            <?php if (isset($_SESSION['mensagem'])): ?>
                                <div class="alert alert-info">
                                    <?php
                                    echo $_SESSION['mensagem'];
                                    unset($_SESSION['mensagem']);
                                    ?>
                                </div>
                            <?php endif; ?>
                            <!-- Espaço para informativos -->
                            <div class="mb-3">
                                <h5 class="text-primary text-center">Informativos do Sistema</h5>
                                <ul class="list-group">
                                    <li class="list-group-item">Bem-vindo! Use o menu lateral para navegar.</li>
                                    <li class="list-group-item">Adicione, edite ou visualize usuários facilmente.</li>
                                    <li class="list-group-item">Fique atento a novidades nesta área!</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
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
</script>
</body>