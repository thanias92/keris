<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

// Manajemen User
$routes->group('manajemen-user', ['filter' => ['auth', 'admin']], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->post('store', 'UserController::store');
    $routes->post('update/(:num)', 'UserController::update/$1');
    $routes->post('delete/(:num)', 'UserController::delete/$1');
});

// Dashboard
$routes->get('/', 'DashboardController::index');

// =====================================================
// PENETAPAN KONTEKS (MODULAR CONTROLLER VERSION)
// =====================================================
$routes->group('penetapan-konteks', ['namespace' => 'App\Controllers\PenetapanKonteks', 'filter' => 'auth'], function ($routes) {

    /* ==============================
        DEFAULT (TAB KONTEKS)
    ============================== */
    $routes->get('/', 'KonteksController::index');
    $routes->get('konteks', 'KonteksController::index');

    // CRUD KONTEKS
    $routes->post('konteks/store', 'KonteksController::store');
    $routes->post('konteks/update', 'KonteksController::update');
    $routes->post('konteks/delete', 'KonteksController::delete');
    $routes->post('konteks/set-active', 'KonteksController::setActive');
    $routes->post('konteks/reset-active', 'KonteksController::resetActive');

    // AJAX TABLE REFRESH
    $routes->get('konteks/table', 'KonteksController::ajaxTable');

    /* ==============================
       PROSES BISNIS
    ============================== */
    $routes->get('proses-bisnis', 'ProsesBisnisController::index');

    $routes->post('proses-bisnis/store', 'ProsesBisnisController::store');
    $routes->post('proses-bisnis/update/(:num)', 'ProsesBisnisController::update/$1');
    $routes->post('proses-bisnis/delete/(:num)', 'ProsesBisnisController::delete/$1');

    // AJAX
    $routes->get('proses-bisnis/detail/(:num)', 'ProsesBisnisController::detail/$1');
    $routes->get('proses-bisnis/generate-kode', 'ProsesBisnisController::generateKode');


    /* ==============================
       SASARAN KINERJA
    ============================== */
    $routes->get('sasaran-kinerja', 'SasaranKinerjaController::index');

    $routes->post('sasaran-kinerja/store', 'SasaranKinerjaController::store');
    $routes->post('sasaran-kinerja/update/(:num)', 'SasaranKinerjaController::update/$1');
    $routes->post('sasaran-kinerja/delete/(:num)', 'SasaranKinerjaController::delete/$1');

    // AJAX
    $routes->get('sasaran-kinerja/detail/(:num)', 'SasaranKinerjaController::detail/$1');
    $routes->get('sasaran-kinerja/generate-kode', 'SasaranKinerjaController::generateKode');


    /* ==============================
       PEMANGKU KEPENTINGAN
    ============================== */
    $routes->get('pemangku', 'PemangkuController::index');

    $routes->post('pemangku/store', 'PemangkuController::store');
    $routes->post('pemangku/update/(:num)', 'PemangkuController::update/$1');
    $routes->post('pemangku/delete/(:num)', 'PemangkuController::delete/$1');

    $routes->get('pemangku/detail/(:num)', 'PemangkuController::detail/$1');


    /* ==============================
       PERATURAN TERKAIT
    ============================== */
    $routes->get('peraturan', 'PeraturanController::index');

    $routes->post('peraturan/store', 'PeraturanController::store');
    $routes->post('peraturan/update/(:num)', 'PeraturanController::update/$1');
    $routes->post('peraturan/delete/(:num)', 'PeraturanController::delete/$1');

    $routes->get('peraturan/detail/(:num)', 'PeraturanController::detail/$1');


    /* ==============================
       MASTER DATA (GLOBAL)
    ============================== */
    $routes->get('kriteria', 'MasterDataController::kriteria');
    $routes->get('matriks', 'MasterDataController::matriks');
    $routes->get('selera', 'MasterDataController::selera');
    $routes->get('sasaran-strategis', 'MasterDataController::sasaranStrategis');
});

// Identifikasi Risiko
$routes->group('identifikasi-risiko', function ($routes) {
    $routes->get('/', 'IdentifikasiRisikoController::index');

    // ===== AJAX GENERATE =====
    $routes->get('generate-kode','IdentifikasiRisikoController::generateKodeRisiko');

    // ===== CRUD =====
    $routes->post('store', 'IdentifikasiRisikoController::store');
    $routes->post('update/(:num)', 'IdentifikasiRisikoController::update/$1');
    $routes->post('delete/(:num)', 'IdentifikasiRisikoController::delete/$1');
    // ===== AJAX DETAIL =====
    $routes->get('detail/(:num)', 'IdentifikasiRisikoController::detail/$1');
    $routes->get('detail-area/(:num)', 'IdentifikasiRisikoController::detailArea/$1');
});

// Analisis Risiko
$routes->group('analisis-risiko', function ($routes) {
    $routes->get('/', 'AnalisisRisikoController::index');
    $routes->get('detail/(:num)', 'AnalisisRisikoController::detail/$1');
    $routes->post('store', 'AnalisisRisikoController::store');
    $routes->post('update/(:num)', 'AnalisisRisikoController::update/$1');
    $routes->post('delete/(:num)', 'AnalisisRisikoController::delete/$1');
    $routes->post('preview', 'AnalisisRisikoController::preview');
});
