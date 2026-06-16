<?php

namespace App\Repositorios;

use PDO;

// Repositorio encargado de las consultas SQL del modulo de Doctores.
// Los controladores usan esta clase para no escribir SQL directamente en la capa HTTP.
class RepositorioDoctor
{
    public function __construct(private PDO $conexion)
    {
    }

    public function crear(array $doctor): bool
    {
        // La insercion usa parametros para proteger los datos recibidos desde Android o Postman.
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
        // El orden por apellidos y nombres facilita mostrar una lista estable en Android.
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
        // Se toma el mayor correlativo existente para crear un codigo interno consistente.
        $sql = "SELECT MAX(CAST(SUBSTRING(IdDoctor, 7) AS UNSIGNED)) AS ultimo
                FROM Doctores
                WHERE IdDoctor REGEXP '^DOC-AA[0-9]+$'";

        $ultimo = (int) $this->conexion->query($sql)->fetchColumn();
        $siguiente = $ultimo + 1;

        return 'DOC-AA' . str_pad((string) $siguiente, 2, '0', STR_PAD_LEFT);
    }

    public function buscarHospitalPorCodigoONombre(string $hospital): ?array
    {
        // Permite que Android envie el codigo o el nombre del hospital asociado.
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
        // Esta consulta confirma que el doctor se asocie a un hospital previamente registrado.
        $sql = 'SELECT COUNT(*) FROM Hospitales WHERE IdHospital = :IdHospital';

        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute(['IdHospital' => $idHospital]);

        return (int) $sentencia->fetchColumn() > 0;
    }
}
