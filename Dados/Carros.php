<?php
require_once 'db.php';

class Carros
{
    public static function atualizar($id, $modelo, $ano, $cor, $marca_id, $modelo_id, $preco, $imagem)
    {
        $conn = DataBase::conectar();
        $stmt_check = $conn->prepare("SELECT Id FROM carros WHERE Id = :Id");
        $stmt_check->bindParam(':Id', $id);
        $stmt_check->bindParam(':modelo', $modelo);
        $stmt_check->bindParam(':ano', $ano);
        $stmt_check->bindParam(':cor', $cor);
        $stmt_check->bindParam(':marca_id', $marca_id);
        $stmt_check->bindParam(':modelo_id', $modelo_id);
        $stmt_check->bindParam(':preco', $preco);
        $stmt_check->bindParam(':imagem', $imagem);

        $stmt_check->execute();


        $stmt = $conn->prepare("UPDATE carros SET modelo = :modelo, ano = :ano, cor = :cor, marca_id = :marca_id, modelo_id = :modelo_id, preco = :preco, imagem = :imagem WHERE Id = :Id");
        $stmt->bindParam(':Id', $id);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':cor', $cor);
        $stmt->bindParam(':marca_id', $marca_id);
        $stmt->bindParam(':modelo_id', $modelo_id);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':imagem', $imagem);
        return $stmt->execute();
    }

    public static function obterPorId($id)
    {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare("SELECT * FROM carros WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

    // public static function listar()
    // {
    //     $conn = DataBase::conectar();
    //     $itensPorPagina = 10;
    //     $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

    //     if ($paginaAtual < 1) {
    //         $paginaAtual = 1;
    //     }

    //     $offset = ($paginaAtual - 1) * $itensPorPagina;
        
    //     $total_query = $conn->query("SELECT COUNT(*) FROM usuarios");
    //     $total_itens = $total_query->fetchColumn();

    //     $total_paginas = ceil($total_itens / $itensPorPagina);


    //     $stmt = $conn->prepare("SELECT * FROM usuarios LIMIT :offset, :itensPorPagina");
    //     $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    //     $stmt->bindParam(':itensPorPagina', $itensPorPagina, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $dados['usuarios'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     $dados['total_paginas'] = $total_paginas;
    //     $dados['pagina_atual'] = $paginaAtual;
    //     return $dados;
    // }

    // public static function criar($nome, $idade, $email)
    // {
    //     $conn = DataBase::conectar();
    //     $stmt = $conn->prepare("INSERT INTO usuarios (Nome, Idade, Email) VALUES (:nome, :idade, :email)");
    //     $stmt->bindParam(':nome', $nome);
    //     $stmt->bindParam(':idade', $idade);
    //     $stmt->bindParam(':email', $email);
    //     return $stmt->execute();
    // }

   

    // public static function buscarPorEmail($email)
    // {
    //     $conn = DataBase::conectar();
    //     $stmt = $conn->prepare("SELECT * FROM usuarios WHERE Email = :Email");
    //     $stmt->bindParam(':Email', $email);
    //     $stmt->execute();
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

   
//     public static function deletar($id)
//     {
//         $conn = DataBase::conectar();
//         $stmt = $conn->prepare("DELETE FROM usuarios WHERE Id = :Id");
//         $stmt->bindParam(':Id', $id);
//         return $stmt->execute();
//     }
// } 
