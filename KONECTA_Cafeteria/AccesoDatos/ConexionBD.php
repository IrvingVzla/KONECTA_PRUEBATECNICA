<?php
class Conexion
{
    public static function ConexionPostgres()
    {
        $host = "localhost"; // El servidor de PostgreSQL (puede ser una IP o un dominio)
        $dbname = "KONECTA_Cafeteria"; // El nombre de tu base de datos
        $username = "postgres"; // Tu nombre de usuario de PostgreSQL
        $password = "digiturno"; // Tu contraseña de PostgreSQL

        try {
            $conn = new PDO("pgsql:host=$host; dbname=$dbname", $username, $password);
        } 
        
        catch ( PDOException $exception) {
            echo ("No se pudo acceder a la base de datos," . $exception);
        }
        return $conn;
    }
}
?>