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
$routes->get('/', 'DashboardController::index', ['filter' => 'auth']);

// Bank Risiko
$routes->group('bank-risiko', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'BankRisikoController::index');

    $routes->get('table', 'BankRisikoController::ajaxTable');
    $routes->get('list', 'BankRisikoController::list');

    $routes->group('', ['filter' => 'admin'], function ($routes) {
        $routes->post('store', 'BankRisikoController::store');
        $routes->post('update/(:num)', 'BankRisikoController::update/$1');
        $routes->post('delete/(:num)', 'BankRisikoController::delete/$1');
    });
});

// PENETAPAN KONTEKS
$routes->group('penetapan-konteks', ['namespace' => 'App\Controllers\PenetapanKonteks', 'filter' => 'auth'], function ($routes) {

    // DEFAULT (TAB KONTEKS)
    $routes->get('/', 'KonteksController::index');
    $routes->get('konteks', 'KonteksController::index');

    // CRUD KONTEKS
    $routes->post('konteks/store', 'KonteksController::store');
    $routes->post('konteks/update', 'KonteksController::update');
    $routes->post('konteks/delete', 'KonteksController::delete');
    $routes->post('konteks/set-active', 'KonteksController::setActive');
    $routes->post('konteks/reset-active', 'KonteksController::resetActive');
    $routes->get('konteks/detail/(:num)', 'KonteksController::detail/$1');

    // AJAX
    $routes->get('konteks/table', 'KonteksController::ajaxTable');
    $routes->get('konteks/get-pemilik-provinsi', 'KonteksController::getPemilikProvinsi');
    $routes->get('konteks/get-pengelola-list', 'KonteksController::getPengelolaList');
    $routes->get('konteks/get-kegiatan/(:num)', 'KonteksController::getKegiatanBySatuanKerja/$1');

    /* ==============================
       PROSES BISNIS
    ============================== */
    $routes->get('proses-bisnis', 'ProsesBisnisController::index');
    $routes->post('proses-bisnis/sync', 'ProsesBisnisController::sync');

    // AJAX
    $routes->get('proses-bisnis/table', 'ProsesBisnisController::ajaxTable');


    /* ==============================
       SASARAN KINERJA
    ============================== */
    $routes->get('sasaran-kinerja', 'SasaranKinerjaController::index');

    $routes->post('sasaran-kinerja/store', 'SasaranKinerjaController::store');
    $routes->post('sasaran-kinerja/update/(:num)', 'SasaranKinerjaController::update/$1');
    $routes->post('sasaran-kinerja/delete/(:num)', 'SasaranKinerjaController::delete/$1');
    $routes->get('sasaran-kinerja/detail/(:num)', 'SasaranKinerjaController::detail/$1');

    // AJAX
    $routes->get('sasaran-kinerja/table', 'SasaranKinerjaController::ajaxTable');


    /* ==============================
       PEMANGKU KEPENTINGAN
    ============================== */
    $routes->get('pemangku', 'PemangkuController::index');
    $routes->get('pemangku/table', 'PemangkuController::ajaxTable');
    $routes->get('pemangku/detail/(:num)', 'PemangkuController::detail/$1');
    $routes->post('pemangku/store', 'PemangkuController::store');
    $routes->post('pemangku/update/(:num)', 'PemangkuController::update/$1');
    $routes->post('pemangku/delete/(:num)', 'PemangkuController::delete/$1');

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
$routes->group('identifikasi-risiko', ['filter' => 'auth'], function ($routes) {

    // INDEX
    $routes->get('/', 'IdentifikasiRisikoController::index');

    // KONTEKS AKTIF
    $routes->post('set-active', 'IdentifikasiRisikoController::setActive');
    $routes->post('reset-active', 'IdentifikasiRisikoController::resetActive');

    // CRUD
    $routes->post('store', 'IdentifikasiRisikoController::store');
    $routes->post('update/(:num)', 'IdentifikasiRisikoController::update/$1');
    $routes->post('delete/(:num)', 'IdentifikasiRisikoController::delete/$1');

    // AJAX DETAIL
    $routes->get('detail/(:num)', 'IdentifikasiRisikoController::detail/$1');
    $routes->get('detail-area/(:num)', 'IdentifikasiRisikoController::detailArea/$1');

    // AJAX TABLE
    $routes->get('table', 'IdentifikasiRisikoController::ajaxTable');

    // BANK RISIKO (autocomplete)
    $routes->get('bank-risiko', 'IdentifikasiRisikoController::getBankRisiko');
});

// Analisis Risiko
$routes->group('analisis-risiko', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'AnalisisRisikoController::index');

    // KONTEKS AKTIF
    $routes->post('set-active', 'AnalisisRisikoController::setActive');
    $routes->post('reset-active', 'AnalisisRisikoController::resetActive');

    // CRUD
    $routes->post('store', 'AnalisisRisikoController::store');
    $routes->post('update/(:num)', 'AnalisisRisikoController::update/$1');
    $routes->post('delete/(:num)', 'AnalisisRisikoController::delete/$1');

    // AJAX DETAIL
    $routes->get('detail/(:num)', 'AnalisisRisikoController::detail/$1');
    $routes->get('detail-identifikasi/(:num)', 'AnalisisRisikoController::detailIdentifikasi/$1');

    // PREVIEW SKOR
    $routes->post('preview', 'AnalisisRisikoController::preview');
});

// EVALUASI RISIKO
$routes->group('evaluasi-risiko', ['filter' => 'auth'], function ($routes) {

    // INDEX
    $routes->get('/', 'EvaluasiRisikoController::index');

    // KONTEKS AKTIF
    $routes->post('set-active', 'EvaluasiRisikoController::setActive');
    $routes->post('reset-active', 'EvaluasiRisikoController::resetActive');

    // CRUD
    $routes->post('store', 'EvaluasiRisikoController::store');
    $routes->post('update/(:num)', 'EvaluasiRisikoController::update/$1');
    $routes->post('delete/(:num)', 'EvaluasiRisikoController::delete/$1');

    // AJAX DETAIL
    $routes->get('detail/(:num)', 'EvaluasiRisikoController::detail/$1');
    $routes->get('detail-analisis/(:num)', 'EvaluasiRisikoController::detailAnalisis/$1');

    // AJAX TABLE
    $routes->get('table', 'EvaluasiRisikoController::ajaxTable');

    // DATA ANALISIS (untuk dropdown / referensi)
    $routes->get('analisis-list', 'EvaluasiRisikoController::getAnalisisList');
});

// RENCANA PENANGANAN RISIKO
$routes->group('rencana-penanganan', ['filter' => 'auth'], function ($routes) {

    // INDEX
    $routes->get('/', 'RencanaPenangananController::index');

    // KONTEKS AKTIF
    $routes->post('set-active', 'RencanaPenangananController::setActive');
    $routes->post('reset-active', 'RencanaPenangananController::resetActive');

    // CRUD
    $routes->post('store', 'RencanaPenangananController::store');
    $routes->post('update/(:num)', 'RencanaPenangananController::update/$1');
    $routes->post('delete/(:num)', 'RencanaPenangananController::delete/$1');

    // AJAX DETAIL
    $routes->get('detail/(:num)', 'RencanaPenangananController::detail/$1');
    $routes->get('detail-evaluasi/(:num)', 'RencanaPenangananController::detailEvaluasi/$1');

    $routes->get('kriteria-kemungkinan', 'RencanaPenangananController::getKriteriaKemungkinan');
    $routes->get('kriteria-dampak',      'RencanaPenangananController::getKriteriaDampak');
});

// PEMANTAUAN RISIKO
$routes->group('pemantauan-risiko', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/',                        'PemantauanRisikoController::index');
    $routes->post('set-active',              'PemantauanRisikoController::setActive');
    $routes->post('reset-active',            'PemantauanRisikoController::resetActive');
    $routes->get('detail/(:num)',            'PemantauanRisikoController::detail/$1');
    $routes->post('store',                   'PemantauanRisikoController::store');
    $routes->post('delete/(:num)', 'PemantauanRisikoController::delete/$1');
    $routes->delete('bukti/(:num)',          'PemantauanRisikoController::deleteBukti/$1');
    // [FIX] Route baru: view bukti di tab baru (full screen + tombol download)
    $routes->get('bukti/view/(:num)',        'PemantauanRisikoController::viewBukti/$1');
    $routes->get('bukti/download/(:num)',    'PemantauanRisikoController::downloadBukti/$1');
});

// PELAPORAN RISIKO
$routes->group('pelaporan-risiko', ['filter' => 'auth'], function ($routes) {

    // INDEX
    $routes->get('/', 'PelaporanRisikoController::index');

    // CONTEXT
    $routes->post('set-active', 'PelaporanRisikoController::setActive');
    $routes->post('reset-active', 'PelaporanRisikoController::resetActive');

    // PERIODE
    $routes->post('set-periode', 'PelaporanRisikoController::setPeriode');

    // DETAIL
    $routes->get('detail/(:num)', 'PelaporanRisikoController::detail/$1');

    // 🔥 VALIDASI (APPROVE / REJECT)
    $routes->post('validasi/(:num)', 'PelaporanRisikoController::validasi/$1');

    // EXPORT
    $routes->get('export', 'PelaporanRisikoController::export');
    $routes->get('print', 'PelaporanRisikoController::print');
});
