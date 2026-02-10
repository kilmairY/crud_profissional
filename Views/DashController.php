<?php

require_once __DIR__ . '/../Dados/db.php';
require_once __DIR__ . '/../Dados/Usuario.php';

class DashController{

    public static function dashUsuarios(){
        $conn = DataBase::conectar();
        $queryTotal = $conn->prepare('SELECT COUNT(*) as total FROM usuarios
    ');
    $queryTotal->execute();
        $totalUsuarios = $queryTotal->fetch(PDO::FETCH_ASSOC)['total'];
  
        $queryTotal = $conn->prepare('SELECT COUNT(*) as total FROM usuarios WHERE Tipo_Usuario = "admin"
    '); 
        $queryTotal->execute();
        $totalAdmins = $queryTotal->fetch(PDO::FETCH_ASSOC)['total'];
  

        return [
            'totalUsuarios' => $totalUsuarios,
            'totalAdmins' => $totalAdmins
        ];
    }
}