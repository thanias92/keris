<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//Dashboard
$routes->get('/', 'DashboardController::index');

//Bank Risiko
$routes->get('/bank-risiko', 'BankRisikoController::index');

// Penetapan Konteks
$routes->get('penetapan-konteks', 'PenetapanKonteksController::index');
$routes->get('penetapan-konteks/create', 'PenetapanKonteksController::create');
$routes->post('penetapan-konteks/store', 'PenetapanKonteksController::store');

//Identifikasi Risiko
$routes->group('identifikasi-risiko', function ($routes) {
    $routes->get('/', 'IdentifikasiRisikoController::index');
    $routes->get('create', 'IdentifikasiRisikoController::create');
    $routes->post('store', 'IdentifikasiRisikoController::store');
    $routes->get('view/(:num)', 'IdentifikasiRisikoController::view/$1');
    $routes->get('edit/(:num)', 'IdentifikasiRisikoController::edit/$1');
    $routes->post('update/(:num)', 'IdentifikasiRisikoController::update/$1');
    $routes->post('delete/(:num)', 'IdentifikasiRisikoController::delete/$1');
    $routes->get('delete/(:num)', 'IdentifikasiRisikoController::delete/$1');
});


$routes->get('/penetapan-level-risiko', 'LevelRisiko::index');
$routes->get('/monitoring-risiko', 'MonitoringRisiko::index');
$routes->get('/tindak-lanjut', 'TindakLanjut::index');

$routes->group('master', function ($routes) {
    $routes->get('tim', 'MasterTim::index');
    $routes->get('user', 'MasterUser::index');
    $routes->get('level-risiko', 'MasterLevelRisiko::index');
});
