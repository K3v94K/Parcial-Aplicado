<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Crea la aplicacion Slim que recibira las solicitudes HTTP de la API.
$app = AppFactory::create();

// Permite que Slim interprete cuerpos JSON enviados por POST.
$app->addBodyParsingMiddleware();

// Activa el middleware de rutas para que Slim pueda ubicar cada endpoint.
$app->addRoutingMiddleware();

// Muestra errores durante el desarrollo local. En hosting puede desactivarse.
$app->addErrorMiddleware(true, true, true);

// Ruta de prueba para confirmar que la API responde antes de crear los modulos.
$app->get('/', function ($request, $response) {
    $response->getBody()->write(json_encode([
        'success' => true,
        'message' => 'API MedControl AA13032 funcionando correctamente',
        'data' => null
    ]));

    return $response->withHeader('Content-Type', 'application/json');
});

// Las rutas se separan por entidad para mantener ordenada la API.
require __DIR__ . '/../src/rutas/rutasHospital.php';
require __DIR__ . '/../src/rutas/rutasDoctor.php';

$app->run();
