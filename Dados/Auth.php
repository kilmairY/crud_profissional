<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'Db.php';

class Auth
{
    
    public static function email_existe($email)
    {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare('SELECT COUNT(*) FROM usuarios WHERE Email = :Email
    ');
        $stmt->execute([':Email' => $email]);
        return $stmt->fetchColumn() > 0;
    }



    public static function registrar($nome, $idade, $email, $senha, $tipoUsuario)
    {
        require_once __DIR__ . '/Confirm.php';
        require_once __DIR__ . '/../Views/EmailService.php';

        $hash = password_hash($senha, PASSWORD_DEFAULT);
        
        $token = Confirm::gerarToken($email);

        $emailService = new EmailService();
        $resultadoEmail = $emailService->enviarEmailConfirmacao($email, $token);
        // Se houve erro ao enviar o e-mail, redireciona com erro
        if ($resultadoEmail !== true) {
            header('Location: ../form_registro.php?erro_email=1');
            exit();
        }

        // Se e-mail foi bem-sucedido cadastra o usuário no banco
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $conn = DataBase::conectar();

            if (self::email_existe($email)) {
                throw new Exception("Email já registrado.");
            }

            $stmt =  $conn->prepare('
            INSERT INTO usuarios (Nome, Idade, Email, Senha, Token_Confirm, Email_Verificado, Tipo_Usuario) 
            VALUES (:nome, :idade, :email, :senha, :token, 0, :tipoUsuario)
        ');
            $stmt->execute([
                ':nome' => $nome,
                ':idade' => $idade,
                ':email' => $email,
                ':senha' => $hash,
                ':token' => $token,
                ':tipoUsuario' => $tipoUsuario
            ]);
        }
    }




    public static function login($email, $senha)
    {
        $conn = DataBase::conectar();

        $stmt = $conn->prepare('
        SELECT * FROM usuarios WHERE Email = :email
        ');
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['Senha'])) {
            if ($usuario['Email_Verificado']) {
                // Login bem-sucedido e e-mail verificado
                $_SESSION['usuario'] = [
                    'id' => $usuario['Id'],
                    'nome' => $usuario['Nome'],
                    'email' => $usuario['Email'],
                    'tipo_usuario' => $usuario['Tipo_Usuario'],
                ];
                return $usuario;
            } else {
                // E-mail não verificado
                return (object)[
                    'status' => 'not_verified',
                    'id' => $usuario['Id'],
                    'nome' => $usuario['Nome'],
                    'email' => $usuario['Email'],
                    'tipo_usuario' => $usuario['Tipo_Usuario']
                ];
            }
        } else {
            // Credenciais inválidas
            return null;
        }
    }
}