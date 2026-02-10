<?php
// Views/CarrosController.php

require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/../Dados/Carros.php';
require_once __DIR__ . '/../Dados/ImagensCarros.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? null;
    
    // ============================================
    // CADASTRAR CARRO
    // ============================================
    if ($acao === 'cadastrarCarro') {
        $conn = DataBase::conectar();
        $marca_id = $_POST['marca_id'] ?? null;
        $modelo_id = $_POST['modelo_id'] ?? null;
        $ano = $_POST['ano'] ?? null;
        $cores = $_POST['cor'] ?? null;
        $valor = $_POST['valor'] ?? null;
        
        // Processamento do valor
        if (!empty($valor)) {
            $valor = str_replace(['R$', ' '], '', $valor);
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
            $valor = floatval($valor);
        }

        if ($marca_id && $modelo_id && $ano && $cores && $valor) {
            // Busca nome do modelo
            $stmt = $conn->prepare("SELECT m.nome FROM modelos m WHERE m.id = :modelo_id");
            $stmt->bindParam(':modelo_id', $modelo_id, PDO::PARAM_INT);
            $stmt->execute();
            $modelo_nome = $stmt->fetchColumn();
            
            if (!$modelo_nome) {
                header('Location: ../form_cadastro_carros.php?erro_modelo=1');
                exit();
            }

            // Insere carro SEM imagem
            $stmt1 = $conn->prepare('INSERT INTO carros (modelo, ano, cor, marca_id, modelo_id, preco) VALUES (:modelo, :ano, :cor, :marca_id, :modelo_id, :valor)');
            $stmt1->bindParam(':modelo', $modelo_nome);
            $stmt1->bindParam(':ano', $ano, PDO::PARAM_INT);
            $stmt1->bindParam(':cor', $cores);
            $stmt1->bindParam(':marca_id', $marca_id, PDO::PARAM_INT);
            $stmt1->bindParam(':modelo_id', $modelo_id, PDO::PARAM_INT);
            $stmt1->bindParam(':valor', $valor);
            
            if ($stmt1->execute()) {
                $carro_id = $conn->lastInsertId();
                
                // ========================================
                // PROCESSAR MÚLTIPLAS IMAGENS
                // ========================================
                if (isset($_FILES['imagens']) && !empty($_FILES['imagens']['name'][0])) {
                    $total = count($_FILES['imagens']['name']);
                    
                    for ($i = 0; $i < $total; $i++) {
                        if ($_FILES['imagens']['error'][$i] === UPLOAD_ERR_OK) {
                            $nomeOriginal = $_FILES['imagens']['name'][$i];
                            $tmpName = $_FILES['imagens']['tmp_name'][$i];
                            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
                            $nomeArquivo = time() . '_' . uniqid() . '.' . $extensao;
                            $destino = __DIR__ . '/../Arquivos/' . $nomeArquivo;
                            
                            if (move_uploaded_file($tmpName, $destino)) {
                                // Primeira imagem é a principal
                                $is_principal = ($i === 0) ? 1 : 0;
                                ImagensCarros::adicionar($carro_id, $nomeArquivo, $i, $is_principal);
                            }
                        }
                    }
                }
                
                header('Location: ../form_cadastro_carros.php?sucesso=1');
                exit();
            } else {
                header('Location: ../form_cadastro_carros.php?erro=1');
                exit();
            }
        } else {
            header('Location: ../form_cadastro_carros.php?erro=2');
            exit();
        }
    } 
    
    // ============================================
    // EDITAR CARRO
    // ============================================
    else if ($acao === 'editarCarro') {
        $conn = DataBase::conectar();
        $id = $_POST['id'] ?? null;
        $marca_id = $_POST['marca_id'] ?? null;
        $modelo_id = $_POST['modelo_id'] ?? null;
        $ano = $_POST['ano'] ?? null;
        $cores = $_POST['cor'] ?? null;
        $valor = $_POST['valor'] ?? null;

        // Processamento do valor
        if (!empty($valor)) {
            $valor = str_replace(['R$', ' '], '', $valor);
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
            $valor = floatval($valor);
        }

        if ($id && $marca_id && $modelo_id && $ano && !empty($cores) && $valor !== null) {
            // Busca nome do modelo
            $stmt = $conn->prepare("SELECT m.nome FROM modelos m WHERE m.id = :modelo_id");
            $stmt->bindParam(':modelo_id', $modelo_id, PDO::PARAM_INT);
            $stmt->execute();
            $modelo_nome = $stmt->fetchColumn();
            
            if (!$modelo_nome) {
                header('Location: ../form_cadastro_carros.php?id=' . $id . '&erro_modelo=1');
                exit();
            }

            // Atualiza carro SEM mexer nas imagens
            $stmt2 = $conn->prepare('UPDATE carros SET modelo = :modelo, ano = :ano, cor = :cor, marca_id = :marca_id, modelo_id = :modelo_id, preco = :valor WHERE id = :id');
            $stmt2->bindParam(':modelo', $modelo_nome);
            $stmt2->bindParam(':ano', $ano, PDO::PARAM_INT);
            $stmt2->bindParam(':cor', $cores);
            $stmt2->bindParam(':marca_id', $marca_id, PDO::PARAM_INT);
            $stmt2->bindParam(':modelo_id', $modelo_id, PDO::PARAM_INT);
            $stmt2->bindParam(':valor', $valor);
            $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($stmt2->execute()) {
                // ========================================
                // ADICIONAR NOVAS IMAGENS (se houver)
                // ========================================
                if (isset($_FILES['imagens']) && !empty($_FILES['imagens']['name'][0])) {
                    $imagensExistentes = ImagensCarros::buscarPorCarro($id);
                    $proximaOrdem = count($imagensExistentes);
                    $total = count($_FILES['imagens']['name']);
                    
                    for ($i = 0; $i < $total; $i++) {
                        if ($_FILES['imagens']['error'][$i] === UPLOAD_ERR_OK) {
                            $nomeOriginal = $_FILES['imagens']['name'][$i];
                            $tmpName = $_FILES['imagens']['tmp_name'][$i];
                            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
                            $nomeArquivo = time() . '_' . uniqid() . '_' . $i . '.' . $extensao;
                            $destino = __DIR__ . '/../Arquivos/' . $nomeArquivo;
                            
                            if (move_uploaded_file($tmpName, $destino)) {
                                // Se não tem imagem principal, a primeira vira principal
                                $temPrincipal = !empty(ImagensCarros::buscarPrincipal($id));
                                $is_principal = (!$temPrincipal && $i === 0) ? 1 : 0;
                                
                                ImagensCarros::adicionar($id, $nomeArquivo, $proximaOrdem + $i, $is_principal);
                            }
                        }
                    }
                }
                
                header('Location: ../form_cadastro_carros.php?id=' . $id . '&sucessoed=1');
                exit();
            } else {
                header('Location: ../form_cadastro_carros.php?id=' . $id . '&erroed=1');
                exit();
            }
        } else {
            header('Location: ../form_cadastro_carros.php?erro=2');
            exit();
        }
    }
}