<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index');

//Identifikasi Risiko
$routes->get('/identifikasi-risiko', 'IdentifikasiRisikoController::index');
$routes->get('identifikasi-risiko/create', 'IdentifikasiRisikoController::create');
$routes->post('identifikasi-risiko/store', 'IdentifikasiRisikoController::store');

$routes->get('/penetapan-level-risiko', 'LevelRisiko::index');
$routes->get('/monitoring-risiko', 'MonitoringRisiko::index');
$routes->get('/tindak-lanjut', 'TindakLanjut::index');

$routes->group('master', function ($routes) {
    $routes->get('tim', 'MasterTim::index');
    $routes->get('user', 'MasterUser::index');
    $routes->get('level-risiko', 'MasterLevelRisiko::index');
});
