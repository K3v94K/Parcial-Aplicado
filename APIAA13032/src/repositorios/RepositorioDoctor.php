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
                    IdDoctor,
                    NombresDoctor,
                    ApellidosDoctor,
                    Especialidad,
                    TurnoAtencion,
                    PacientesMinDiarios,
                    Sueldo,
                    IdHospital
                FROM Doctores
                ORDER BY ApellidosDoctor, NombresDoctor';

        return $this->conexion->query($sql)->fetchAll();
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
