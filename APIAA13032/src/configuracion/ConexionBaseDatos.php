<?php

namespace App\Configuracion;

use PDO;
use PDOException;

class ConexionBaseDatos
{
    private string $host = '127.0.0.1';
    private string $database = 'p3_aa13032_salud';
    private string $user = 'root';
    private string $password = '';

    public function getConnection(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";

        try {
            // PDO permite trabajar con MySQL usando consultas preparadas y manejo de errores.
            return new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $exception) {
            // Se lanza una excepcion general para evitar mostrar datos internos de conexion.
            throw new PDOException('No se pudo conectar con la base de datos local.');
        }
    }
}
