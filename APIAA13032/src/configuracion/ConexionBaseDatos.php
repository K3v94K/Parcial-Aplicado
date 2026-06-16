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
        // En local se usan los valores de XAMPP; en hosting se reemplazan con variables de entorno.
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
            // PDO permite trabajar con MySQL usando consultas preparadas y manejo de errores.
            return new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $exception) {
            // Se evita exponer credenciales o datos internos de conexion en la respuesta HTTP.
            throw new PDOException('No se pudo conectar con la base de datos configurada.');
        }
    }
}
