<?php
// Dados/ImagensCarros.php

require_once __DIR__ . '/db.php';

class ImagensCarros
{
    /**
     * Adiciona uma imagem ao carro
     */
    public static function adicionar($carro_id, $nome_arquivo, $ordem = 0, $is_principal = 0)
    {
        $conn = DataBase::conectar();
        
        // Se for principal, remove o flag das outras
        if ($is_principal) {
            self::removerPrincipal($carro_id);
        }
        
        $stmt = $conn->prepare("
            INSERT INTO imagens_carros (carro_id, nome_arquivo, ordem, is_principal)
            VALUES (:carro_id, :nome_arquivo, :ordem, :is_principal)
        ");
        
        $stmt->bindParam(':carro_id', $carro_id, PDO::PARAM_INT);
        $stmt->bindParam(':nome_arquivo', $nome_arquivo);
        $stmt->bindParam(':ordem', $ordem, PDO::PARAM_INT);
        $stmt->bindParam(':is_principal', $is_principal, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Remove flag de principal de todas as imagens do carro
     */
    public static function removerPrincipal($carro_id)
    {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare("
            UPDATE imagens_carros 
            SET is_principal = 0 
            WHERE carro_id = :carro_id
        ");
        $stmt->bindParam(':carro_id', $carro_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    
     /* Busca todas as imagens de um carro */
    
    public static function buscarPorCarro($carro_id)
    {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare("
            SELECT * FROM imagens_carros 
            WHERE carro_id = :carro_id 
            ORDER BY ordem ASC, is_principal DESC, id ASC
        ");
        $stmt->bindParam(':carro_id', $carro_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Busca imagem principal do carro
     */
    public static function buscarPrincipal($carro_id)
    {
        $conn = DataBase::conectar();
        $stmt = $conn->prepare("
            SELECT * FROM imagens_carros 
            WHERE carro_id = :carro_id AND is_principal = 1
            LIMIT 1
        ");
        $stmt->bindParam(':carro_id', $carro_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Deleta uma imagem
     */
    public static function deletar($id)
    {
        $conn = DataBase::conectar();
        
        // Busca o nome do arquivo antes de deletar
        $stmt = $conn->prepare("SELECT nome_arquivo FROM imagens_carros WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $imagem = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($imagem) {
            // Deleta do banco
            $stmt = $conn->prepare("DELETE FROM imagens_carros WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Deleta o arquivo físico
            $caminhoArquivo = __DIR__ . '/../Arquivos/' . $imagem['nome_arquivo'];
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Deleta todas as imagens de um carro
     */
    public static function deletarPorCarro($carro_id)
    {
        $imagens = self::buscarPorCarro($carro_id);
        
        foreach ($imagens as $imagem) {
            self::deletar($imagem['id']);
        }
        
        return true;
    }
}