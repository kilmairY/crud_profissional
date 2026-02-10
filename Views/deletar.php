<?php

session_start();
require ("VerificaAdmin.php");
require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/UsuarioController.php';

VerificaAdmin::verificarAcesso();

UsuarioController::deletarUsuario($_GET['Id']);
header('Location: ../index.php');
exit();
