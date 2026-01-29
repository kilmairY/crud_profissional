<?php
// Serviço para confirmação de e-mail
require_once __DIR__ . '/Db.php';

class Confirm {
    // Gera um token único para confirmação de e-mail
    public static function gerarToken($email) {
        return hash('sha256', $email . uniqid('', true));
    }

    // Salva o token de confirmação no banco de dados
    public static function salvarToken($email, $token) {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare('UPDATE usuarios SET Token_Confirm = :token WHERE Email = :email');
        $stmt->execute([':token' => $token, ':email' => $email]);
    }

    // Confirma o e-mail do usuário a partir do token recebido
    public static function confirmarEmail($token) {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare('SELECT * FROM usuarios WHERE Token_Confirm = :token');
        $stmt->execute([':token' => $token]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            // Marca o e-mail como verificado e remove o token
            $stmt = $conn->prepare('UPDATE usuarios SET Email_Verificado = 1, Token_Confirm = NULL WHERE Id = :Id');
            $stmt->execute([':Id' => $usuario['Id']]);
            return true;
        }
        return false;
    }
}
