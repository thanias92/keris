<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Dashboard
$routes->get('/', 'DashboardController::index');

// Penetapan Konteks
$routes->group('penetapan-konteks', function ($routes) {
    // ===== TAB / LIST =====
    $routes->get('/', 'PenetapanKonteksController::index');
    $routes->get('proses-bisnis', 'PenetapanKonteksController::prosesBisnis');
    $routes->get('sasaran-kinerja', 'PenetapanKonteksController::sasaranKinerja');
    $routes->get('pemangku', 'PenetapanKonteksController::pemangkuKepentingan');
    $routes->get('peraturan', 'PenetapanKonteksController::peraturanTerkait');
    $routes->get('kriteria', 'PenetapanKonteksController::kriteria');
    $routes->get('matriks', 'PenetapanKonteksController::matriksRisiko');
    $routes->get('selera', 'PenetapanKonteksController::seleraRisiko');
    $routes->get('sasaran-strategis', 'PenetapanKonteksController::sasaranStrategis');

    $routes->post('set-active-konteks','PenetapanKonteksController::setActiveKonteks');
    $routes->post('reset-active-konteks', 'PenetapanKonteksController::resetActiveKonteks');

    // ===== AJAX DETAIL =====
    $routes->get('proses-bisnis/detail/(:num)', 'PenetapanKonteksController::detailProsesBisnis/$1');
    $routes->get('sasaran-kinerja/detail/(:num)', 'PenetapanKonteksController::detailSasaranKinerja/$1');
    $routes->get('pemangku/detail/(:num)', 'PenetapanKonteksController::detailPemangkuKepentingan/$1');
    $routes->get('peraturan/detail/(:num)', 'PenetapanKonteksController::detailPeraturanTerkait/$1');
    // ===== AJAX GENERATE =====
    $routes->get('proses-bisnis/generate-kode', 'PenetapanKonteksController::generateKodeProses');
    $routes->get('sasaran-kinerja/generate-kode', 'PenetapanKonteksController::generateKodeSasaran');
    // ===== CRUD KONTEKS =====
    $routes->post('konteks/store', 'PenetapanKonteksController::storeKonteks');
    // ===== CRUD PROSES BISNIS =====
    $routes->post('proses-bisnis/store', 'PenetapanKonteksController::storeProsesBisnis');
    $routes->post('proses-bisnis/update/(:num)', 'PenetapanKonteksController::updateProsesBisnis/$1');
    $routes->post('proses-bisnis/delete/(:num)', 'PenetapanKonteksController::deleteProsesBisnis/$1');
    // ===== CRUD SASARAN KINERJA =====
    $routes->post('sasaran-kinerja/store', 'PenetapanKonteksController::storeSasaranKinerja');
    $routes->post('sasaran-kinerja/update/(:num)', 'PenetapanKonteksController::updateSasaranKinerja/$1');
    $routes->post('sasaran-kinerja/delete/(:num)', 'PenetapanKonteksController::deleteSasaranKinerja/$1');
    // ===== CRUD PEMANGKU KEPENTINGAN =====
    $routes->post('pemangku/store', 'PenetapanKonteksController::storePemangkuKepentingan');
    $routes->post('pemangku/update/(:num)', 'PenetapanKonteksController::updatePemangkuKepentingan/$1');
    $routes->post('pemangku/delete/(:num)', 'PenetapanKonteksController::deletePemangkuKepentingan/$1');
    // ===== CRUD PERATURAN TERKAIT =====
    $routes->post('peraturan/store', 'PenetapanKonteksController::storePeraturanTerkait');
    $routes->post('peraturan/update/(:num)', 'PenetapanKonteksController::updatePeraturanTerkait/$1');
    $routes->post('peraturan/delete/(:num)', 'PenetapanKonteksController::deletePeraturanTerkait/$1');
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
