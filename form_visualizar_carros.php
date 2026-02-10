
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                <div class="alert alert-info">Nenhum carro cadastrado.</div>
            <?php else: ?>
        </div>
        <?php foreach ($carros as $carro): ?>
            <?php // Buscar imagens do carro atual para exibir no carrossel ?>
            <?php $imagens = ImagensCarros::buscarPorCarro($carro['id']); ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <div class="row text-left">
                            <div class="col-6 text-left">
                                <?= htmlspecialchars($carro['modelo']) ?>
                            </div>
                            <?php if ($isAdmin): ?>
                                <div class="col-6 text-right">
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
                    <?php // Carrossel de imagens do carro ?>
                    <div id="carrosselCarro" class="carousel slide" data-ride="carousel">
                        <!-- Indicadores -->
                        <?php // Indicadores do carrossel (bolinhas) ?>
                        <ol class="carousel-indicators">
                            <?php foreach ($imagens as $index => $img): ?>
                                <li data-target="#carrosselCarro"
                                    data-slide-to="<?= $index ?>"
                                    class="<?= $index === 0 ? 'active' : '' ?>"></li>
                            <?php endforeach; ?>
                        </ol>

                        <!-- Slides -->
                        <?php // Slides das imagens ?>
                        <div class="carousel-inner">
                            <?php if (!empty($imagens)): ?>
                                <?php foreach ($imagens as $index => $img): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <img src="Arquivos/<?= htmlspecialchars($img['nome_arquivo']) ?>"
                                            class="d-block w-100"
                                            alt="Imagem <?= $index + 1 ?>"
                                            style="max-height: 500px; object-fit: contain;">
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <?php // Caso não tenha imagens, exibe mensagem ?>
                                <div class="carousel-item active">
                                    <div class="d-flex align-items-center justify-content-center" style="height: 400px; background: #f0f0f0;">
                                        <p class="text-muted">Sem imagens</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Controles -->
                        <?php // Controles de navegação do carrossel (setas) ?>
                        <?php if (count($imagens) > 1): ?>
                            <a class="carousel-control-prev" href="#carrosselCarro" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" href="#carrosselCarro" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>