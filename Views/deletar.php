<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../form_login.php');
    exit();
}
require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/UsuarioController.php';

UsuarioController::deletarUsuario($_GET['id']);
header('Location: ../index.php');
exit();
