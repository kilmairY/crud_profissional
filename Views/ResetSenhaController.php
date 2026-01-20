<?php
require_once __DIR__ . '/../Dados/ResetSenha.php';
require_once __DIR__ . '/../Dados/Auth.php';
require_once __DIR__ . '/../Dados/Usuario.php';
require_once __DIR__ . '/../Dados/db.php';

class ResetSenhaController
{
    public static function solicitar()
    {
        $email = $_POST['email'];

        // Validar formato do email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Email inválido. <br><a href='../form_esqueci_senha.php'>Tentar novamente</a>");
        }

        // Validar se o email está registrado no banco
        if (!Usuario::buscarPorEmail($email)) {
            die("Email não encontrado no sistema. <br><a href='../form_esqueci_senha.php'>Tentar novamente</a>");
        }

        $token = bin2hex(random_bytes(10));
        $expira = date('y-m-d H:i:s', strtotime('+1 hour'));

        Reset_Senha::removerToken($email);
        Reset_Senha::criarToken($email, $token, $expira);

        header('Location: ../form_resetar_senha.php?token=' . $token);
        exit();
    }

    public static function resetar()
    {
        if (!isset($_POST['token']) || !isset($_POST['senha'])) {
            die("Token ou senha não fornecidos.");
        }

        $token = $_POST['token'];
        $nova_senha = $_POST['senha'];

        $registro = Reset_Senha::buscarToken($token);

        if (!$registro) {
            die("Token inválido ou expirado. <br><a href='../form_login.php'>Clique Aqui para voltar</a>");
        } else {

            $hash = password_hash($nova_senha, PASSWORD_DEFAULT);

            $conn = database::conectar();
            $stmt = $conn->prepare(
                "UPDATE usuarios SET senha = :senha WHERE email = :email"
            );
            $stmt->execute([':senha' => $hash, ':email' => $registro['email']]);

            Reset_Senha::removerToken($registro['email']);

            header('Location: ../form_login.php?sucesso=1');
            exit();
        }
    }
}
