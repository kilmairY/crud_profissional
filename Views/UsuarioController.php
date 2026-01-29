<?php
require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/../Dados/Usuario.php';
require_once __DIR__ . '/../Dados/Auth.php';

class UsuarioController
{

    public static function index()
    {
        return Usuario::listar();
    }

    public static function criarUsuario($nome, $idade, $email, $tipoUsuario)
    {
        try {
            Auth::registrar(
                $_POST['Nome'],
                $_POST['Idade'],
                $_POST['Email'],
                $_POST['Senha'],
                $_POST['Tipo_Usuario'],
            );
            header('Location: ../index.php?sucesso=1');
        } catch (Exception $e) {
            header('Location: ../form_registro.php?erro=1');
            exit();
        }
    }
    public static function obterUsuario($id)
    {
        return Usuario::obterPorId($id);
    }
    public static function atualizarUsuario($id, $nome, $idade, $email)
    {
        return Usuario::atualizar($id, $nome, $idade, $email);
    }

    public static function deletarUsuario($id)
    {
        return Usuario::deletar($id);
    }
}
