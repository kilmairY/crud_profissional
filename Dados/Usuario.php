<?php
require_once 'db.php';

class Usuario
{
    public static function listar()
    {
        $conn = DataBase::conectar();
        $itensPorPagina = 10;
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

        if ($paginaAtual < 1) {
            $paginaAtual = 1;
        }

        $offset = ($paginaAtual - 1) * $itensPorPagina;
        
        $total_query = $conn->query("SELECT COUNT(*) FROM usuarios");
        $total_itens = $total_query->fetchColumn();

        $total_paginas = ceil($total_itens / $itensPorPagina);


        $stmt = $conn->prepare("SELECT * FROM usuarios LIMIT :offset, :itensPorPagina");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':itensPorPagina', $itensPorPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados['usuarios'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dados['total_paginas'] = $total_paginas;
        $dados['pagina_atual'] = $paginaAtual;
        return $dados;
    }

    public static function criar($nome, $idade, $email)
    {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare("INSERT INTO usuarios (Nome, Idade, Email) VALUES (:nome, :idade, :email)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public static function obterPorId($id)
    {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE Id = :Id");
        $stmt->bindParam(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function buscarPorEmail($email)
    {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE Email = :Email");
        $stmt->bindParam(':Email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function atualizar($id, $nome, $idade, $email)
    {
        $conn = DataBase::conectar();
        $stmt_check = $conn->prepare("SELECT Id FROM usuarios WHERE LOWER(Email) = LOWER(:Email) AND Id != :Id");
        $stmt_check->bindParam(':Email', $email);
        $stmt_check->bindParam(':Id', $id);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            throw new Exception("Email já cadastrado.");
        }

        $stmt = $conn->prepare("UPDATE usuarios SET Nome = :Nome, Idade = :Idade, Email = :Email WHERE Id = :Id");
        $stmt->bindParam(':Id', $id);
        $stmt->bindParam(':Nome', $nome);
        $stmt->bindParam(':Idade', $idade);
        $stmt->bindParam(':Email', $email);
        return $stmt->execute();
    }
    public static function deletar($id)
    {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE Id = :Id");
        $stmt->bindParam(':Id', $id);
        return $stmt->execute();
    }
} 
