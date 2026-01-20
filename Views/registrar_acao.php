<?php
session_start();
require_once __DIR__ . '/../Dados/Auth.php';
require_once __DIR__ . '/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        AuthController::registro();
        header('Location: ../form_registro.php?sucesso=1');
        exit();
    } catch (Exception $e) {
        header('Location: ../form_registro.php?erro=1');
        exit();
    }
} else {
    header('Location: ../index.php');
    exit();
}
