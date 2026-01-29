<?php
require_once __DIR__ . '/../Dados/db.php';

class ResetSenha
{

    public static function criarToken($email, $token, $expira)
    {
        $conn = database::conectar();

        $stmt = $conn->prepare(
            "INSERT INTO reset_tokens (email, token, expira_em) 
        VALUES (?, ?, ?)"
        );
        $stmt->execute([$email, $token, $expira]);
    }

    public static function buscarToken($token)
    {
        $conn = database::conectar();

        $stmt = $conn->prepare(
            "SELECT * FROM reset_tokens 
            WHERE token = ? AND expira_em >= NOW()"
        );
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function removerToken($email)
    {
        $conn = database::conectar();

        $stmt = $conn->prepare(
            "DELETE FROM reset_tokens WHERE email = ?"
        );
        $stmt->execute([$email]);
    }
}
