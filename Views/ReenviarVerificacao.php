<?php
require_once __DIR__ . '/../Dados/Usuario.php';
require_once __DIR__ . '/../Dados/Confirm.php';
require_once __DIR__ . '/EmailService.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
    $email = urldecode($_GET['email']);
    $usuario = Usuario::buscarPorEmail($email);
    if ($usuario && isset($usuario['token_confirm'])) {
        $token = $usuario['token_confirm'];
        if (!$token) {
            $token = Confirm::gerarToken($email);
            Confirm::salvarToken($email, $token);
        }
        $emailService = new EmailService();
        $resultadoEmail = $emailService->enviarEmailConfirmacao($email, $token);
        if ($resultadoEmail === true) {
            header('Location: ../form_login.php?reenviado=1');
            exit();
        } else {
            header('Location: ../form_login.php?erro_reenvio=1');
            exit();
        }
    } else {
        header('Location: ../form_login.php?erro_reenvio=1');
        exit();
    }
} else {
    header('Location: ../form_login.php?erro_reenvio=1');
    exit();
}