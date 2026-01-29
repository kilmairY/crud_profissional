<?php
require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/../Dados/Auth.php';

class AuthController {
    public static function registro(){
        Auth::registrar(
            $_POST['Nome'], 
            $_POST['Idade'],
            $_POST['Email'], 
            $_POST['Senha'],
            $_POST['Tipo_Usuario'],
        );
        header('Location: ../form_login.php?cadastro_sucesso=1');
        exit();
    }
    public static function login(){
        $usuario = Auth::login($_POST['Email'], $_POST['Senha']);
        if ($usuario && is_array($usuario)) {
            $_SESSION['usuario'] = [
                'id' => $usuario['Id'],
                'nome' => $usuario['Nome'],
                'email' => $usuario['Email'],
                'tipo_usuario'=> $usuario['Tipo_Usuario'],
            ];
            header('Location: ../index.php');
        } elseif ($usuario->status === 'not_verified') {
            header('Location: ../form_login.php?erro_verificacao=1&email=' . urlencode($usuario->email));
            exit();
        } else {
            header('Location: ../form_login.php?erro=1');
            exit();
        }
    }
}
    