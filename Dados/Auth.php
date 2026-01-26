<?php
require_once 'db.php';

class Auth
{

    // Registra um novo usuário e envia e-mail de confirmação
    public static function registrar($nome, $idade, $email, $senha)
    {
        require_once __DIR__ . '/Confirm.php';
        require_once __DIR__ . '/../Views/EmailService.php';
        $conn = database::conectar();

        if (self::email_existe($email)) {
            throw new Exception("Email já registrado.");
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);
        // Gera token de confirmação para o novo usuário
        $token = Confirm::gerarToken($email);

        $stmt =  $conn->prepare('
        INSERT INTO usuarios (nome, idade, email, senha, email_verificado, token_confirm) 
        VALUES (:nome, :idade, :email, :senha, 0, :token)
    ');
        $stmt->execute([
            ':nome' => $nome,
            ':idade' => $idade,
            ':email' => $email,
            ':senha' => $hash,
            ':token' => $token  
        ]);

        // Envia e-mail de confirmação com o token gerado
        $emailService = new EmailService();
        $emailService->enviarEmailConfirmacao($email, $token);
    }

    public static function login($email, $senha)
    {
        $conn = database::conectar();

        $stmt = $conn->prepare('
        SELECT * FROM usuarios WHERE email = :email
    ');
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            if (isset($usuario['email_verificado']) && $usuario['email_verificado'] == 1) {
                return $usuario;
            } else {
                // E-mail não verificado
                return 'not_verified';
            }
        } else {
            return false;
        }
    }

    public static function email_existe($email)
    {
        $conn = database::conectar();
        $stmt = $conn->prepare('
        SELECT COUNT(*) FROM usuarios WHERE email = :email
    ');
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}
