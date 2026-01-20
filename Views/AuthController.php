<?php
require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/../Dados/Auth.php';

class AuthController {
    public static function registro(){
        Auth::registrar(
            $_POST['nome'], 
            $_POST['idade'],
            $_POST['email'], 
            $_POST['senha']
        );
        header('Location: ../index.php');
        exit();
    }
    public static function login(){
        $usuario = Auth::login($_POST['email'], $_POST['senha']);
        if ($usuario) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email']
            ];
            header('Location: ../index.php');
        } else {
            header('Location: ../form_login.php?erro=1');
            exit();
        }
    }
}
