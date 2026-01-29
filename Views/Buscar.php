<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../Dados/db.php';

$conn = DataBase::conectar();
$pdo = $conn;

$dadosBusca = json_decode(file_get_contents('php://input'), true);
$termoBusca = $dadosBusca['termo'] ?? '';
$paginaAtual = $dadosBusca['paginaAtual'] ?? 1;
$limite = 10;
$offset = ($paginaAtual - 1) * $limite;

if(!empty($termoBusca)){
   
    $stmt1 = $pdo->prepare("SELECT * FROM usuarios WHERE Nome LIKE :termo OR Email LIKE :termo");
    $stmt1->bindValue(':termo', "%$termoBusca%", PDO::PARAM_STR);
    $stmt1->execute();
    $totalResultados = $stmt1->rowCount();
    $totalPaginas = ceil($totalResultados / $limite);


    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE Nome LIKE :termo OR Email LIKE :termo LIMIT :limite OFFSET :offset");
    $stmt->bindValue(':termo', "%$termoBusca%", PDO::PARAM_STR);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
   
    $stmt1 = $pdo->prepare("SELECT * FROM usuarios");
    $stmt1->execute();
    $totalResultados = $stmt1->rowCount();
    $totalPaginas = ceil($totalResultados / $limite);

    $stmt = $pdo->query("SELECT * FROM usuarios LIMIT 10 OFFSET $offset");
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$retorno = [
    'pagina_atual' => (int)$paginaAtual,
    'paginas' => $totalPaginas,
    'resultados' => $resultados
];

echo json_encode($retorno);