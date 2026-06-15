<?php

use App\Controladores\ControladorHospital;

// Aqui se registraran las rutas relacionadas con Hospitales.
// La logica principal quedara en ControladorHospital para no mezclar capas.
$app->post('/hospitales', [ControladorHospital::class, 'crear']);
$app->get('/hospitales/{id}', [ControladorHospital::class, 'buscarPorId']);
