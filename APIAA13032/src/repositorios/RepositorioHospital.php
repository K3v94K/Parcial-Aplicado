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

    public function buscarPorId(string $idHospital): ?array
    {
        // La busqueda por llave primaria permite responder el GET /hospitales/{id}.
        $sql = 'SELECT IdHospital, NomHospital, CapacidadAtencion, Especialidades
                FROM Hospitales
                WHERE IdHospital = :IdHospital';

        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute(['IdHospital' => $idHospital]);

        $hospital = $sentencia->fetch();

        return $hospital ?: null;
    }
}
