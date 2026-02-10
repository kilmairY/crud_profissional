<?php
// Views/DefinirImagemPrincipal.php

require_once __DIR__ . '/../Dados/db.php';

session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $img_id = $_POST['img_id'] ?? null;
    
    if ($img_id) {
        $conn = DataBase::conectar();
        
        // Busca o carro_id da imagem
        $stmt = $conn->prepare("SELECT carro_id FROM imagens_carros WHERE id = :id");
        $stmt->bindParam(':id', $img_id, PDO::PARAM_INT);
        $stmt->execute();
        $carro_id = $stmt->fetchColumn();
        
        if ($carro_id) {
            // Remove principal de todas
            $stmt = $conn->prepare("UPDATE imagens_carros SET is_principal = 0 WHERE carro_id = :carro_id");
            $stmt->bindParam(':carro_id', $carro_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Define a nova principal
            $stmt = $conn->prepare("UPDATE imagens_carros SET is_principal = 1 WHERE id = :id");
            $stmt->bindParam(':id', $img_id, PDO::PARAM_INT);
            $sucesso = $stmt->execute();
            
            echo json_encode(['sucesso' => $sucesso]);
        } else {
            echo json_encode(['sucesso' => false]);
        }
    } else {
        echo json_encode(['sucesso' => false]);
    }
} else {
    echo json_encode(['sucesso' => false]);
}