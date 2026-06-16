<?php

namespace App\Ayudas;

use Psr\Http\Message\ResponseInterface as Response;

// Centraliza la estructura JSON que comparten las respuestas correctas y las respuestas de error.
class AyudanteRespuesta
{
    public static function exito(Response $response, string $mensaje, mixed $datos = null, int $codigo = 200): Response
    {
        return self::json($response, true, $mensaje, $datos, $codigo);
    }

    public static function error(Response $response, string $mensaje, mixed $datos = null, int $codigo = 400): Response
    {
        return self::json($response, false, $mensaje, $datos, $codigo);
    }

    private static function json(Response $response, bool $exito, string $mensaje, mixed $datos, int $codigo): Response
    {
        // Define las claves esperadas por el cliente movil en todas las respuestas HTTP.
        $contenido = json_encode([
            'success' => $exito,
            'message' => $mensaje,
            'data' => $datos,
        ], JSON_UNESCAPED_UNICODE);

        $response->getBody()->write($contenido);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($codigo);
    }
}
