<?php

namespace App\Repositorios;

use PDO;

// Ejecuta las consultas SQL relacionadas con doctores.
class RepositorioDoctor
{
    public function __construct(private PDO $conexion)
    {
    }

    public function crear(array $doctor): bool
    {
        // Usa parametros enlazados para insertar datos sin concatenar valores recibidos por HTTP.
        $sql = 'INSERT INTO Doctores (
                    IdDoctor,
                    NombresDoctor,
                    ApellidosDoctor,
                    Especialidad,
                    TurnoAtencion,
                    PacientesMinDiarios,
                    Sueldo,
                    IdHospital
                ) VALUES (
                    :IdDoctor,
                    :NombresDoctor,
                    :ApellidosDoctor,
                    :Especialidad,
                    :TurnoAtencion,
                    :PacientesMinDiarios,
                    :Sueldo,
                    :IdHospital
                )';

        $sentencia = $this->conexion->prepare($sql);

        return $sentencia->execute([
            'IdDoctor' => $doctor['IdDoctor'],
            'NombresDoctor' => $doctor['NombresDoctor'],
            'ApellidosDoctor' => $doctor['ApellidosDoctor'],
            'Especialidad' => $doctor['Especialidad'],
            'TurnoAtencion' => $doctor['TurnoAtencion'],
            'PacientesMinDiarios' => (int) $doctor['PacientesMinDiarios'],
            'Sueldo' => (float) $doctor['Sueldo'],
            'IdHospital' => $doctor['IdHospital'],
        ]);
    }

    public function listarTodos(): array
    {
        // Une doctores con hospitales para devolver el nombre del hospital junto al codigo almacenado.
        $sql = 'SELECT
                    d.IdDoctor,
                    d.NombresDoctor,
                    d.ApellidosDoctor,
                    d.Especialidad,
                    d.TurnoAtencion,
                    d.PacientesMinDiarios,
                    d.Sueldo,
                    d.IdHospital,
                    h.NomHospital
                FROM Doctores d
                INNER JOIN Hospitales h ON h.IdHospital = d.IdHospital
                ORDER BY d.ApellidosDoctor, d.NombresDoctor';

        return $this->conexion->query($sql)->fetchAll();
    }

    public function generarSiguienteCodigo(): string
    {
        // Calcula el siguiente correlativo disponible manteniendo el prefijo usado por la tabla.
        $sql = "SELECT MAX(CAST(SUBSTRING(IdDoctor, 7) AS UNSIGNED)) AS ultimo
                FROM Doctores
                WHERE IdDoctor REGEXP '^DOC-AA[0-9]+$'";

        $ultimo = (int) $this->conexion->query($sql)->fetchColumn();
        $siguiente = $ultimo + 1;

        return 'DOC-AA' . str_pad((string) $siguiente, 2, '0', STR_PAD_LEFT);
    }

    public function buscarHospitalPorCodigoONombre(string $hospital): ?array
    {
        // Busca el hospital por llave primaria o por coincidencia parcial del nombre visible.
        $sql = 'SELECT IdHospital, NomHospital
                FROM Hospitales
                WHERE IdHospital = :Hospital OR NomHospital LIKE :NomHospital
                ORDER BY
                    CASE WHEN IdHospital = :HospitalOrden THEN 0 ELSE 1 END,
                    NomHospital
                LIMIT 1';

        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute([
            'Hospital' => $hospital,
            'HospitalOrden' => $hospital,
            'NomHospital' => "%{$hospital}%",
        ]);

        $resultado = $sentencia->fetch();

        return $resultado ?: null;
    }

    public function existeHospital(string $idHospital): bool
    {
        // Verifica la existencia del hospital antes de usarlo como llave foranea.
        $sql = 'SELECT COUNT(*) FROM Hospitales WHERE IdHospital = :IdHospital';

        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute(['IdHospital' => $idHospital]);

        return (int) $sentencia->fetchColumn() > 0;
    }
}
