<?php

namespace App\Configuracion;

use PDO;
use PDOException;

class ConexionBaseDatos
{
    private string $host;
    private string $port;
    private string $database;
    private string $user;
    private string $password;

    public function __construct()
    {
        // Usa valores locales por defecto y permite reemplazarlos con variables de entorno en hosting.
        $this->host = getenv('DB_HOST') ?: '127.0.0.1';
        $this->port = getenv('DB_PORT') ?: '3306';
        $this->database = getenv('DB_NAME') ?: 'p3_aa13032_salud';
        $this->user = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: '';
    }

    public function getConnection(): PDO
    {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset=utf8mb4";

        try {
            // Configura PDO para reportar excepciones y devolver registros como arreglos asociativos.
            return new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $exception) {
            // Devuelve un mensaje controlado para no exponer parametros internos de conexion.
            throw new PDOException('No se pudo conectar con la base de datos configurada.');
        }
    }
}
