<?php
// Views/DeletarImagem.php

require_once __DIR__ . '/../Dados/ImagensCarros.php';

session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $img_id = $_POST['img_id'] ?? null;
    
    if ($img_id) {
        $sucesso = ImagensCarros::deletar($img_id);
        echo json_encode(['sucesso' => $sucesso]);
    } else {
        echo json_encode(['sucesso' => false]);
    }
} else {
    echo json_encode(['sucesso' => false]);
}