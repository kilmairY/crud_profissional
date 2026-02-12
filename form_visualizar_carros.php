<?php
session_start();
require_once __DIR__ . '/Dados/db.php';
require_once __DIR__ . '/Dados/ImagensCarros.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: form_login.php');
    exit();
}

$isAdmin = isset($_SESSION['usuario']['tipo_usuario']) && $_SESSION['usuario']['tipo_usuario'] === 'admin';

$conn = DataBase::conectar();
$stmt = $conn->query('SELECT * FROM carros');
$carros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Carros</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background: linear-gradient(to bottom, #f4f6f9 0%, #e9ecef 100%);
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 40px 0;
        }

        .card.carro-card {
            border-radius: 1.5rem;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            background: #fff;
            transition: all 0.3s ease;
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

        .card.carro-card:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .carro-card .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .carro-card .card-text {
            font-size: 1.1rem;
            color: #333;
        }

        .carro-card .btn-outline-primary {
            border-radius: 10px;
            border: 2px solid #667eea;
            color: #667eea;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .carro-card .btn-outline-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            border-color: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .carro-card .carousel-inner img {
            border-radius: 1rem;
            background: #e9ecef;
        }

        .carro-card .carousel-indicators li {
            background-color: #667eea;
        }

        .carro-card .carousel-control-prev-icon,
        .carro-card .carousel-control-next-icon {
            filter: invert(40%) sepia(100%) saturate(500%) hue-rotate(200deg);
        }

        .carro-card .sem-imagem {
            height: 300px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 1.3rem;
            border-radius: 1rem;
        }

        .carro-card .card-body {
            padding: 2rem 2.5rem 2rem 2.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #0068bd 100%);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #0068bd 0%, #667eea 100%);
        }
        

        .alert-info {
            font-size: 1.1rem;
            border-radius: 0.7rem;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Carros Cadastrados</h2>
        <div class="row mb-3">
            <div class="col-3 text-left">
                <a href="form_inicio.php" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fas fa-home mr-1"></i> Inicio
                </a>
            </div>
            <div class="col-9 text-right">
                <?php if ($isAdmin): ?>
                    <a href="form_cadastro_carros.php" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>Adicionar Novo Carro
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <?php if (empty($carros)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center shadow-sm">Nenhum carro cadastrado.</div>
                </div>
            <?php else: ?>
                <?php foreach ($carros as $carro): ?>
                    <?php $imagens = ImagensCarros::buscarPorCarro($carro['id']); ?>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="card carro-card w-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">
                                    <div class="row text-left">
                                        <div class="col-7 text-left">
                                            <i class="fas fa-car-side mr-2 text-primary"></i>
                                            <?= htmlspecialchars($carro['modelo']) ?>
                                        </div>
                                        <?php if ($isAdmin): ?>
                                            <div class="col-5 text-right">
                                                <a href="form_cadastro_carros.php?id=<?= $carro['id'] ?>" class="btn btn-sm btn-outline-primary ml-2 align-end">Editar</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </h5>
                                <p class="card-text">
                                    <?php switch ($carro['marca_id']) {
                                        case 1:
                                            echo "<strong>Marca:</strong> Chevrolet<br>";
                                            break;
                                        case 2:
                                            echo "<strong>Marca:</strong> Fiat<br>";
                                            break;
                                        case 3:
                                            echo "<strong>Marca:</strong> Ford<br>";
                                            break;
                                        case 4:
                                            echo "<strong>Marca:</strong> Honda<br>";
                                            break;
                                        case 5:
                                            echo "<strong>Marca:</strong> Hyundai<br>";
                                            break;
                                        case 6:
                                            echo "<strong>Marca:</strong> Jeep<br>";
                                            break;
                                        case 7:
                                            echo "<strong>Marca:</strong> Nissan<br>";
                                            break;
                                        case 8:
                                            echo "<strong>Marca:</strong> Toyota<br>";
                                            break;
                                        case 9:
                                            echo "<strong>Marca:</strong> Volkswagen<br>";
                                            break;
                                        default:
                                            echo "<strong>Marca:</strong> Desconhecida<br>";
                                    } ?>
                                    <strong>Cor:</strong> <?= htmlspecialchars($carro['cor']) ?><br>
                                    <strong>Ano:</strong> <?= htmlspecialchars($carro['ano']) ?><br>
                                    <strong>Valor:</strong> R$ <?= number_format($carro['preco'], 2, ',', '.') ?><br>
                                </p>
                                <?php // Carrossel de imagens do carro 
                                ?>
                                <div id="carrosselCarro<?= $carro['id'] ?>" class="carousel slide mb-3" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <?php foreach ($imagens as $index => $img): ?>
                                            <li data-target="#carrosselCarro<?= $carro['id'] ?>" data-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
                                        <?php endforeach; ?>
                                    </ol>
                                    <div class="carousel-inner">
                                        <?php if (!empty($imagens)): ?>
                                            <?php foreach ($imagens as $index => $img): ?>
                                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                                    <img src="Arquivos/<?= htmlspecialchars($img['nome_arquivo']) ?>" class="d-block w-100" alt="Imagem <?= $index + 1 ?>" style="max-height: 250px; object-fit: contain;">
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="carousel-item active">
                                                <div class="sem-imagem">Sem imagens</div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (count($imagens) > 1): ?>
                                        <a class="carousel-control-prev" href="#carrosselCarro<?= $carro['id'] ?>" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        </a>
                                        <a class="carousel-control-next" href="#carrosselCarro<?= $carro['id'] ?>" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Dropzone e scripts removidos para restaurar ao estado anterior -->
</body>

</html>