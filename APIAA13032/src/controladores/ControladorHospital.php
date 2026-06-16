<?php

namespace App\Controladores;

use App\Ayudas\AyudanteRespuesta;
use App\Configuracion\ConexionBaseDatos;
use App\Repositorios\RepositorioHospital;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Valida las solicitudes HTTP de hospitales antes de enviar los datos al repositorio.
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
        // Requiere los campos definidos como obligatorios para insertar un hospital completo.
        $camposRequeridos = ['NomHospital', 'CapacidadAtencion', 'Especialidades'];

        foreach ($camposRequeridos as $campo) {
            if (!isset($datos[$campo]) || trim((string) $datos[$campo]) === '') {
                return AyudanteRespuesta::error($response, "El campo {$campo} es obligatorio.", null, 400);
            }
        }

        if (!isset($datos['IdHospital']) || trim((string) $datos['IdHospital']) === '') {
            $datos['IdHospital'] = $this->repositorioHospital->generarSiguienteCodigo();
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
        // Obtiene el valor enviado en la ruta para buscar por codigo o por nombre.
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

    public function listar(Request $request, Response $response): Response
    {
        $hospitales = $this->repositorioHospital->listarTodos();

        if (count($hospitales) === 0) {
            return AyudanteRespuesta::exito($response, 'No hay hospitales registrados.', []);
        }

        return AyudanteRespuesta::exito($response, 'Hospitales consultados correctamente.', $hospitales);
    }
}
