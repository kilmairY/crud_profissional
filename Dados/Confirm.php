<?php
// Serviço para confirmação de e-mail
require_once __DIR__ . '/db.php';

class Confirm {
    // Gera um token único para confirmação de e-mail
    public static function gerarToken($email) {
        return hash('sha256', $email . uniqid('', true));
    }

    // Salva o token de confirmação no banco de dados
    public static function salvarToken($email, $token) {
        $conn = database::conectar();
        $stmt = $conn->prepare('UPDATE usuarios SET token_confirm = :token WHERE email = :email');
        $stmt->execute([':token' => $token, ':email' => $email]);
    }

    // Confirma o e-mail do usuário a partir do token recebido
    public static function confirmarEmail($token) {
        $conn = database::conectar();
        $stmt = $conn->prepare('SELECT * FROM usuarios WHERE token_confirm = :token');
        $stmt->execute([':token' => $token]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            // Marca o e-mail como verificado e remove o token
            $stmt = $conn->prepare('UPDATE usuarios SET email_verificado = 1, token_confirm = NULL WHERE id = :id');
            $stmt->execute([':id' => $usuario['id']]);
            return true;
        }
        return false;
    }
}
