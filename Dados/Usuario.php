<?php
require_once 'db.php';

class Usuario
{
    public static function listar()
    {
        $conn = database::conectar();
        $stmt = $conn->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function criar($nome, $idade, $email)
    {
        $conn = database::conectar();
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, idade, email) VALUES (:nome, :idade, :email)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public static function obterPorId($id)
    {
        $conn = database::conectar();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function buscarPorEmail($email)
    {
        $conn = database::conectar();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function atualizar($id, $nome, $idade, $email)
    {
        $conn = database::conectar();
        $stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE LOWER(email) = LOWER(:email) AND id != :id");
        $stmt_check->bindParam(':email', $email);
        $stmt_check->bindParam(':id', $id);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            throw new Exception("Email já cadastrado.");
        }

        $stmt = $conn->prepare("UPDATE usuarios SET nome = :nome, idade = :idade, email = :email WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
    public static function deletar($id)
    {
        $conn = database::conectar();
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
