<?php

use App\Controladores\ControladorDoctor;

// Aqui se registraran las rutas relacionadas con Doctores.
// La logica principal quedara en ControladorDoctor para no mezclar capas.
$app->post('/doctores', [ControladorDoctor::class, 'crear']);
$app->get('/doctores', [ControladorDoctor::class, 'listar']);
