<?php

namespace App\Repositorios;

use PDO;

// Repositorio encargado de las consultas SQL del modulo de Hospitales.
// Esta capa evita escribir SQL directamente dentro de rutas o controladores.
class RepositorioHospital
{
    public function __construct(private PDO $conexion)
    {
    }

    public function crear(array $hospital): bool
    {
        // La consulta preparada evita inyecciones SQL al insertar datos enviados por la API.
        $sql = 'INSERT INTO Hospitales (IdHospital, NomHospital, CapacidadAtencion, Especialidades)
                VALUES (:IdHospital, :NomHospital, :CapacidadAtencion, :Especialidades)';

        $sentencia = $this->conexion->prepare($sql);

        return $sentencia->execute([
            'IdHospital' => $hospital['IdHospital'],
            'NomHospital' => $hospital['NomHospital'],
            'CapacidadAtencion' => $hospital['CapacidadAtencion'],
            'Especialidades' => $hospital['Especialidades'],
        ]);
    }

    public function generarSiguienteCodigo(): string
    {
        // Se toma el mayor correlativo existente para mantener codigos ordenados y faciles de leer.
        $sql = "SELECT MAX(CAST(SUBSTRING(IdHospital, 8) AS UNSIGNED)) AS ultimo
                FROM Hospitales
                WHERE IdHospital REGEXP '^HOSP-AA[0-9]+$'";

        $ultimo = (int) $this->conexion->query($sql)->fetchColumn();
        $siguiente = $ultimo + 1;

        return 'HOSP-AA' . str_pad((string) $siguiente, 2, '0', STR_PAD_LEFT);
    }

    public function listarTodos(): array
    {
        // El listado permite que Android muestre hospitales por nombre en controles de seleccion.
        $sql = 'SELECT IdHospital, NomHospital, CapacidadAtencion, Especialidades
                FROM Hospitales
                ORDER BY NomHospital';

        return $this->conexion->query($sql)->fetchAll();
    }

    public function buscarPorId(string $idHospital): ?array
    {
        // La busqueda acepta codigo exacto o coincidencia por nombre para facilitar el uso desde Android.
        $sql = 'SELECT IdHospital, NomHospital, CapacidadAtencion, Especialidades
                FROM Hospitales
                WHERE IdHospital = :IdHospital OR NomHospital LIKE :NomHospital
                ORDER BY
                    CASE WHEN IdHospital = :IdHospitalOrden THEN 0 ELSE 1 END,
                    NomHospital
                LIMIT 1';

        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute([
            'IdHospital' => $idHospital,
            'IdHospitalOrden' => $idHospital,
            'NomHospital' => "%{$idHospital}%",
        ]);

        $hospital = $sentencia->fetch();

        return $hospital ?: null;
    }
}
