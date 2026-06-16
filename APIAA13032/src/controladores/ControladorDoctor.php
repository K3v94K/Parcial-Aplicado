<?php

namespace App\Controladores;

use App\Ayudas\AyudanteRespuesta;
use App\Configuracion\ConexionBaseDatos;
use App\Repositorios\RepositorioDoctor;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Valida las solicitudes HTTP de doctores antes de enviar los datos al repositorio.
class ControladorDoctor
{
    private RepositorioDoctor $repositorioDoctor;

    public function __construct()
    {
        $conexion = (new ConexionBaseDatos())->getConnection();
        $this->repositorioDoctor = new RepositorioDoctor($conexion);
    }

    public function crear(Request $request, Response $response): Response
    {
        $datos = $request->getParsedBody() ?? [];
        // Requiere los campos necesarios para registrar el doctor y su hospital asociado.
        $camposRequeridos = [
            'NombresDoctor',
            'ApellidosDoctor',
            'Especialidad',
            'TurnoAtencion',
            'PacientesMinDiarios',
            'Sueldo',
            'IdHospital',
        ];

        foreach ($camposRequeridos as $campo) {
            if (!isset($datos[$campo]) || trim((string) $datos[$campo]) === '') {
                return AyudanteRespuesta::error($response, "El campo {$campo} es obligatorio.", null, 400);
            }
        }

        if (!filter_var($datos['PacientesMinDiarios'], FILTER_VALIDATE_INT)) {
            return AyudanteRespuesta::error($response, 'PacientesMinDiarios debe ser un numero entero.', null, 400);
        }

        if (!is_numeric($datos['Sueldo'])) {
            return AyudanteRespuesta::error($response, 'Sueldo debe ser un numero valido.', null, 400);
        }

        if ((int) $datos['PacientesMinDiarios'] <= 0 || (float) $datos['Sueldo'] <= 0) {
            return AyudanteRespuesta::error($response, 'PacientesMinDiarios y Sueldo deben ser mayores que cero.', null, 400);
        }

        if (!isset($datos['IdDoctor']) || trim((string) $datos['IdDoctor']) === '') {
            $datos['IdDoctor'] = $this->repositorioDoctor->generarSiguienteCodigo();
        }

        // Resuelve el hospital a su llave primaria aunque el cliente envie el nombre visible.
        $hospital = $this->repositorioDoctor->buscarHospitalPorCodigoONombre($datos['IdHospital']);

        if ($hospital === null) {
            return AyudanteRespuesta::error($response, 'No existe un hospital asociado al dato indicado.', null, 404);
        }

        $datos['IdHospital'] = $hospital['IdHospital'];
        $datos['NomHospital'] = $hospital['NomHospital'];

        try {
            $this->repositorioDoctor->crear($datos);

            return AyudanteRespuesta::exito($response, 'Doctor registrado correctamente.', $datos, 201);
        } catch (PDOException $exception) {
            return AyudanteRespuesta::error($response, 'No se pudo registrar el doctor. Verifique que el identificador no exista previamente.', null, 409);
        }
    }

    public function listar(Request $request, Response $response): Response
    {
        $doctores = $this->repositorioDoctor->listarTodos();

        if (count($doctores) === 0) {
            return AyudanteRespuesta::exito($response, 'No hay doctores registrados.', []);
        }

        return AyudanteRespuesta::exito($response, 'Doctores consultados correctamente.', $doctores);
    }
}
