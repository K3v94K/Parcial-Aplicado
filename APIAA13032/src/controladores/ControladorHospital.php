<?php

namespace App\Controladores;

use App\Ayudas\AyudanteRespuesta;
use App\Configuracion\ConexionBaseDatos;
use App\Repositorios\RepositorioHospital;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Controlador encargado de validar solicitudes HTTP del modulo de Hospitales.
// Las consultas SQL se mantienen en el repositorio para no mezclar responsabilidades.
class ControladorHospital
{
    private RepositorioHospital $repositorioHospital;

    public function __construct()
    {
        $conexion = (new ConexionBaseDatos())->getConnection();
        $this->repositorioHospital = new RepositorioHospital($conexion);
    }

    public function crear(Request $request, Response $response): Response
    {
        $datos = $request->getParsedBody() ?? [];
        // Se exigen los campos del diagrama para evitar registros incompletos.
        $camposRequeridos = ['IdHospital', 'NomHospital', 'CapacidadAtencion', 'Especialidades'];

        foreach ($camposRequeridos as $campo) {
            if (!isset($datos[$campo]) || trim((string) $datos[$campo]) === '') {
                return AyudanteRespuesta::error($response, "El campo {$campo} es obligatorio.", null, 400);
            }
        }

        try {
            $this->repositorioHospital->crear($datos);

            return AyudanteRespuesta::exito($response, 'Hospital registrado correctamente.', $datos, 201);
        } catch (PDOException $exception) {
            return AyudanteRespuesta::error($response, 'No se pudo registrar el hospital. Verifique que el identificador no exista previamente.', null, 409);
        }
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response
    {
        // El identificador viene desde la ruta GET /hospitales/{id}.
        $idHospital = trim((string) ($args['id'] ?? ''));

        if ($idHospital === '') {
            return AyudanteRespuesta::error($response, 'Debe indicar el identificador del hospital.', null, 400);
        }

        $hospital = $this->repositorioHospital->buscarPorId($idHospital);

        if ($hospital === null) {
            return AyudanteRespuesta::error($response, 'No se encontro un hospital con el identificador indicado.', null, 404);
        }

        return AyudanteRespuesta::exito($response, 'Hospital encontrado correctamente.', $hospital);
    }
}
