<?php

namespace App\Ayudas;

use Psr\Http\Message\ResponseInterface as Response;

// Helper reservado para estandarizar respuestas JSON de exito y error.
// Esto permite que todos los endpoints respondan con el mismo formato.
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
        // Se mantiene una estructura uniforme para que Android procese respuestas predecibles.
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
