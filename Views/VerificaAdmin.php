<?php


Class VerificaAdmin {
public function __construct() {
    session_start();
}

public static function verificarAcesso() {
if (!isset($_SESSION["usuario"]['id'])) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode([
        'error' => 'Acesso negado. Você precisa estar logado para acessar esta página.'
    ]);
    exit;
}


if (empty($_SESSION["usuario"]['tipo_usuario']) || $_SESSION["usuario"]['tipo_usuario'] !== "admin") {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode([
        'error' => 'Acesso negado. Você precisa ser administrador para acessar esta página.'
    ]);
    exit;
}
}
}
?>