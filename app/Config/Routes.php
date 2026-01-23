<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//Dashboard
$routes->get('/', 'DashboardController::index');

//Bank Risiko
$routes->get('/bank-risiko', 'BankRisikoController::index');

//Penetapan Konteks
$routes->group('penetapan-konteks', function ($routes) {
    $routes->get('/', 'PenetapanKonteksController::index');
    $routes->get('create', 'PenetapanKonteksController::create');
    $routes->post('store', 'PenetapanKonteksController::store');
    $routes->get('view/(:num)', 'PenetapanKonteksController::view/$1');
    $routes->get('edit/(:num)', 'PenetapanKonteksController::edit/$1');
    $routes->post('update/(:num)', 'PenetapanKonteksController::update/$1');
    $routes->post('delete/(:num)', 'PenetapanKonteksController::delete/$1');
    $routes->get('delete/(:num)', 'PenetapanKonteksController::delete/$1');
});

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

//Analisis Risiko
$routes->group('analisis-risiko', function ($routes) {
    $routes->get('/', 'AnalisisRisikoController::index');
    $routes->post('store', 'AnalisisRisikoController::store');
});



$routes->get('/penetapan-level-risiko', 'LevelRisiko::index');
$routes->get('/monitoring-risiko', 'MonitoringRisiko::index');
$routes->get('/tindak-lanjut', 'TindakLanjut::index');

$routes->group('master', function ($routes) {
    $routes->get('tim', 'MasterTim::index');
    $routes->get('user', 'MasterUser::index');
    $routes->get('level-risiko', 'MasterLevelRisiko::index');
});
