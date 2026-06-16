<?php

use App\Controladores\ControladorDoctor;

// Define los endpoints HTTP disponibles para la entidad Doctores.
// Cada ruta delega la validacion y la respuesta al controlador correspondiente.
$app->post('/doctores', [ControladorDoctor::class, 'crear']);
$app->get('/doctores', [ControladorDoctor::class, 'listar']);
