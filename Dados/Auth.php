<?php
require_once 'db.php';

class Auth
{

    public static function registrar($nome, $idade, $email, $senha)
    {
        $conn = database::conectar();

        if (self::email_existe($email)) {
            throw new Exception("Email já registrado.");
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt =  $conn->prepare('
        INSERT INTO usuarios (nome, idade, email, senha) 
        VALUES (:nome, :idade, :email, :senha)
    ');
        $stmt->execute([
            ':nome' => $nome,
            ':idade' => $idade,
            ':email' => $email,
            ':senha' => $hash
        ]);
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
            return $usuario;
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
