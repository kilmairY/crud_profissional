<?php

session_start();
include("VerificaAdmin.php");

require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/UsuarioController.php';

UsuarioController::deletarUsuario($_GET['Id']);
header('Location: ../index.php');
exit();
