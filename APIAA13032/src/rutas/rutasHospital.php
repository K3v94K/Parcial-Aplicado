<?php

use App\Controladores\ControladorHospital;

// Define los endpoints HTTP disponibles para la entidad Hospitales.
// Cada ruta delega la validacion y la respuesta al controlador correspondiente.
$app->post('/hospitales', [ControladorHospital::class, 'crear']);
$app->get('/hospitales', [ControladorHospital::class, 'listar']);
$app->get('/hospitales/{id}', [ControladorHospital::class, 'buscarPorId']);
