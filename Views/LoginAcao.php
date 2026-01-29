<?php
session_start();
require_once __DIR__ . '/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AuthController::login();
} else {
    header('Location: ../form_login.php?error=invalid_request');
    exit();
}
