<?php

namespace App\Repositorios;

use PDO;

// Ejecuta las consultas SQL relacionadas con hospitales.
class RepositorioHospital
{
    public function __construct(private PDO $conexion)
    {
    }

    public function crear(array $hospital): bool
    {
        // Usa parametros enlazados para insertar datos sin concatenar valores recibidos por HTTP.
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
        // Calcula el siguiente correlativo disponible manteniendo el prefijo usado por la tabla.
        $sql = "SELECT MAX(CAST(SUBSTRING(IdHospital, 8) AS UNSIGNED)) AS ultimo
                FROM Hospitales
                WHERE IdHospital REGEXP '^HOSP-AA[0-9]+$'";

        $ultimo = (int) $this->conexion->query($sql)->fetchColumn();
        $siguiente = $ultimo + 1;

        return 'HOSP-AA' . str_pad((string) $siguiente, 2, '0', STR_PAD_LEFT);
    }

    public function listarTodos(): array
    {
        // Ordena por nombre para llenar controles de seleccion de forma legible.
        $sql = 'SELECT IdHospital, NomHospital, CapacidadAtencion, Especialidades
                FROM Hospitales
                ORDER BY NomHospital';

        return $this->conexion->query($sql)->fetchAll();
    }

    public function buscarPorId(string $idHospital): ?array
    {
        // Prioriza la coincidencia exacta por codigo y luego permite coincidencias parciales por nombre.
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
