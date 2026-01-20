<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../form_login.php');
    exit();
}
require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/UsuarioController.php';

try {
    UsuarioController::atualizarUsuario($_GET['id'], $_POST['nome'], $_POST['idade'], $_POST['email']);
    header('Location: ../index.php');
} catch (Exception $e) {
    header('Location: ../form_editar.php?id=' . $_GET['id'] . '&erro=' . urlencode($e->getMessage()));
    exit();
}
