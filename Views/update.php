<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../form_login.php');
    exit();
}
require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/UsuarioController.php';

try {
    UsuarioController::atualizarUsuario($_GET['Id'], $_POST['Nome'], $_POST['Idade'], $_POST['Email']);
    header('Location: ../index.php?editar_sucesso=1');
} catch (Exception $e) {
    header('Location: ../form_editar.php?Id=' . $_GET['Id'] . '&erro=' . urlencode($e->getMessage()));
    exit();
}
