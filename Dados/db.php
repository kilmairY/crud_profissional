<?php

class DataBase
{
    private static $conn;

    public static function conectar()
    {
        if (!isset(self::$conn)) {
            self::$conn = new PDO(
                "mysql:host=localhost;dbname=crud_profissional;charset=utf8",
                "root",
                "",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        }
        return self::$conn;
    }
}
