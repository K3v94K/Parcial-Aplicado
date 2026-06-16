<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Inicializa la instancia principal de Slim para procesar las solicitudes HTTP.
$app = AppFactory::create();

// Habilita la lectura de cuerpos JSON enviados por los clientes de la API.
$app->addBodyParsingMiddleware();

// Registra el middleware que resuelve las rutas declaradas en los archivos del modulo.
$app->addRoutingMiddleware();

// Activa el reporte de errores para facilitar la validacion durante la instalacion.
$app->addErrorMiddleware(true, true, true);

// Endpoint base utilizado para comprobar que el servicio esta disponible.
$app->get('/', function ($request, $response) {
    $response->getBody()->write(json_encode([
        'success' => true,
        'message' => 'API MedControl AA13032 funcionando correctamente',
        'data' => null
    ]));

    return $response->withHeader('Content-Type', 'application/json');
});

// Carga las rutas por entidad para separar hospitales y doctores.
require __DIR__ . '/../src/rutas/rutasHospital.php';
require __DIR__ . '/../src/rutas/rutasDoctor.php';

$app->run();
