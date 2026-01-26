<?php
session_start();
require_once __DIR__ . '/AuthController.php';

$idade = filter_input(INPUT_POST, 'idade', FILTER_VALIDATE_INT);

if($idade === false || $idade < 18) {
    header('Location: ../form_registro.php?erro_idade=1');
    exit();
}

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
