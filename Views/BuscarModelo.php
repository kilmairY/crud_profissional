<?php
require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/../Dados/Usuario.php';

header('Content-Type: application/json');
session_start();

$pdo = DataBase::conectar();
$marca_id = $_GET['id'] ?? '';
if ($marca_id) {
    $stmt = $pdo->prepare('SELECT id, nome FROM modelos WHERE marca_id = :id ORDER BY nome ASC');
    $stmt->bindValue(':id', $marca_id, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode([]);
}
