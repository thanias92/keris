<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

// Dashboard
$routes->get('/', 'DashboardController::index');
$routes->get('dashboard', 'DashboardController::index');
$routes->get('dashboard/data', 'DashboardController::data');

// Manajemen User (admin)
$routes->group('manajemen-user', ['filter' => ['auth']], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->post('store', 'UserController::store');
    $routes->post('update/(:num)', 'UserController::update/$1');
    $routes->post('delete/(:num)', 'UserController::delete/$1');
});

// RBAC (Role & Permission)
$routes->group('rbac', ['filter' => ['auth']], function ($routes) {
    $routes->get('role', 'RBAC\RoleController::index');
    $routes->post('role/store', 'RBAC\RoleController::store');
    $routes->post('role/update/(:num)', 'RBAC\RoleController::update/$1');
    $routes->post('role/delete/(:num)', 'RBAC\RoleController::delete/$1');
    $routes->get('role/permissions/(:num)', 'RBAC\RoleController::permissions/$1');
    $routes->post('role/update-permissions/(:num)', 'RBAC\RoleController::updatePermissions/$1');
    $routes->get('unauthorized', 'RBAC\ErrorController::unauthorized');
    $routes->get('permission', 'RBAC\PermissionController::index');
    $routes->post('permission/store', 'RBAC\PermissionController::store');
    $routes->post('permission/update/(:num)', 'RBAC\PermissionController::update/$1');
    $routes->post('permission/delete/(:num)', 'RBAC\PermissionController::delete/$1');
});

// Bank Risiko
$routes->group('bank-risiko', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'BankRisikoController::index');
    $routes->get('table', 'BankRisikoController::ajaxTable');
    $routes->get('list', 'BankRisikoController::list');

    $routes->group('', function ($routes) {
        $routes->post('store', 'BankRisikoController::store');
        $routes->post('update/(:num)', 'BankRisikoController::update/$1');
        $routes->post('delete/(:num)', 'BankRisikoController::delete/$1');
    });
});

// MR Instansi
$routes->group('mr-instansi', ['filter' => ['auth']], function ($routes) {
    $routes->get('/', 'MrInstansiController::index');
    $routes->get('data', 'MrInstansiController::getData');
    $routes->post('sync', 'MrInstansiController::sync');
});

// Master Data
$routes->group('master', ['filter' => ['auth']], function ($routes) {
    $routes->get('tim-kerja', 'Master\SatuanKerjaController::index');
    $routes->get('tim-kerja/table', 'Master\SatuanKerjaController::table');
    $routes->post('tim-kerja/store', 'Master\SatuanKerjaController::store');
    $routes->post('tim-kerja/update/(:num)', 'Master\SatuanKerjaController::update/$1');
    $routes->post('tim-kerja/delete/(:num)', 'Master\SatuanKerjaController::delete/$1');

    $routes->get('kegiatan', 'Master\KegiatanController::index');
    $routes->get('kegiatan/table', 'Master\KegiatanController::table');
    $routes->post('kegiatan/store', 'Master\KegiatanController::store');
    $routes->post('kegiatan/update/(:num)', 'Master\KegiatanController::update/$1');
    $routes->post('kegiatan/delete/(:num)', 'Master\KegiatanController::delete/$1');

    $routes->get('sasaran-strategis', 'Master\SasaranStrategisController::index');
    $routes->get('sasaran-strategis/table', 'Master\SasaranStrategisController::table');
    $routes->post('sasaran-strategis/store', 'Master\SasaranStrategisController::store');
    $routes->post('sasaran-strategis/update/(:num)', 'Master\SasaranStrategisController::update/$1');
    $routes->post('sasaran-strategis/delete/(:num)', 'Master\SasaranStrategisController::delete/$1');

    $routes->get('penugasan-tim', 'Master\PenugasanTimController::index');
    $routes->get('penugasan-tim/table', 'Master\PenugasanTimController::table');
    $routes->get('pengelola/table', 'Master\PengelolaController::table');
    $routes->post('penugasan-tim/store', 'Master\PenugasanTimController::store');
    $routes->post('penugasan-tim/delete/(:num)', 'Master\PenugasanTimController::delete/$1');

    $routes->get('bank-risiko', 'Master\BankRisikoController::index');
    $routes->get('bank-risiko/table', 'Master\BankRisikoController::table');
    $routes->post('bank-risiko/store', 'Master\BankRisikoController::store');
    $routes->post('bank-risiko/update/(:num)', 'Master\BankRisikoController::update/$1');
    $routes->post('bank-risiko/delete/(:num)', 'Master\BankRisikoController::delete/$1');
    $routes->post('bank-risiko/approve/(:num)', 'Master\BankRisikoController::approve/$1');
    $routes->post('bank-risiko/reject/(:num)', 'Master\BankRisikoController::reject/$1');
});

// Penetapan Konteks
$routes->group('penetapan-konteks', [
    'namespace' => 'App\Controllers\PenetapanKonteks',
    'filter' => ['auth']
], function ($routes) {
    $routes->get('/', 'KonteksController::index');
    $routes->get('konteks', 'KonteksController::index');

    $routes->post('konteks/store', 'KonteksController::store');
    $routes->post('konteks/update', 'KonteksController::update');
    $routes->post('konteks/delete', 'KonteksController::delete');
    $routes->post('konteks/set-active', 'KonteksController::setActive');
    $routes->post('konteks/reset-active', 'KonteksController::resetActive');
    $routes->get('konteks/detail/(:num)', 'KonteksController::detail/$1');

    $routes->get('konteks/table', 'KonteksController::ajaxTable');
    $routes->get('konteks/get-pemilik-provinsi', 'KonteksController::getPemilikProvinsi');
    $routes->get('konteks/get-pengelola-list', 'KonteksController::getPengelolaList');
    $routes->get('konteks/get-kegiatan/(:num)', 'KonteksController::getKegiatanBySatuanKerja/$1');

    $routes->get('proses-bisnis', 'ProsesBisnisController::index', [
        'filter' => 'role:admin,operator,ketua'
    ]);

    $routes->post('proses-bisnis/sync', 'ProsesBisnisController::sync', [
        'filter' => 'role:admin,operator'
    ]);

    $routes->get('proses-bisnis/ajax-table', 'ProsesBisnisController::ajaxTable');

    $routes->get('sasaran-kinerja', 'SasaranKinerjaController::index');
    $routes->post('sasaran-kinerja/store', 'SasaranKinerjaController::store');
    $routes->post('sasaran-kinerja/update/(:num)', 'SasaranKinerjaController::update/$1');
    $routes->post('sasaran-kinerja/delete/(:num)', 'SasaranKinerjaController::delete/$1');
    $routes->get('sasaran-kinerja/detail/(:num)', 'SasaranKinerjaController::detail/$1');
    $routes->get('sasaran-kinerja/table', 'SasaranKinerjaController::ajaxTable');

    $routes->get('pemangku', 'PemangkuController::index');
    $routes->get('pemangku/table', 'PemangkuController::ajaxTable');
    $routes->get('pemangku/detail/(:num)', 'PemangkuController::detail/$1');
    $routes->post('pemangku/store', 'PemangkuController::store');
    $routes->post('pemangku/update/(:num)', 'PemangkuController::update/$1');
    $routes->post('pemangku/delete/(:num)', 'PemangkuController::delete/$1');

    $routes->get('peraturan', 'PeraturanController::index');
    $routes->post('peraturan/store', 'PeraturanController::store');
    $routes->post('peraturan/update/(:num)', 'PeraturanController::update/$1');
    $routes->post('peraturan/delete/(:num)', 'PeraturanController::delete/$1');
    $routes->get('peraturan/detail/(:num)', 'PeraturanController::detail/$1');

    $routes->get('kriteria', 'MasterDataController::kriteria');
    $routes->get('matriks', 'MasterDataController::matriks');
    $routes->get('selera', 'MasterDataController::selera');
    $routes->get('sasaran-strategis', 'MasterDataController::sasaranStrategis');
});

// Identifikasi
$routes->group('identifikasi-risiko', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'IdentifikasiRisikoController::index');
    $routes->get('detail/(:num)', 'IdentifikasiRisikoController::detail/$1');
    $routes->get('detail-area/(:num)', 'IdentifikasiRisikoController::detailArea/$1');
    $routes->get('table', 'IdentifikasiRisikoController::ajaxTable');
    $routes->get('bank-risiko', 'IdentifikasiRisikoController::getBankRisiko');
    $routes->post('set-active', 'IdentifikasiRisikoController::setActive');
    $routes->post('reset-active', 'IdentifikasiRisikoController::resetActive');
    $routes->group('', function ($routes) {
        $routes->post('store', 'IdentifikasiRisikoController::store');
        $routes->post('update/(:num)', 'IdentifikasiRisikoController::update/$1');
        $routes->post('delete/(:num)', 'IdentifikasiRisikoController::delete/$1');
        $routes->post('request-bank-risiko', 'IdentifikasiRisikoController::requestBankRisiko');
    });
});

// Analisis
$routes->group('analisis-risiko', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'AnalisisRisikoController::index');
    $routes->get('detail/(:num)', 'AnalisisRisikoController::detail/$1');
    $routes->get('detail-identifikasi/(:num)', 'AnalisisRisikoController::detailIdentifikasi/$1');
    $routes->post('set-active', 'AnalisisRisikoController::setActive');
    $routes->post('reset-active', 'AnalisisRisikoController::resetActive');
    $routes->group('', function ($routes) {
        $routes->post('store', 'AnalisisRisikoController::store');
        $routes->post('update/(:num)', 'AnalisisRisikoController::update/$1');
        $routes->post('delete/(:num)', 'AnalisisRisikoController::delete/$1');
        $routes->post('preview', 'AnalisisRisikoController::preview');
    });
});

// Evaluasi
$routes->group('evaluasi-risiko', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'EvaluasiRisikoController::index');
    $routes->get('detail/(:num)', 'EvaluasiRisikoController::detail/$1');
    $routes->get('detail-analisis/(:num)', 'EvaluasiRisikoController::detailAnalisis/$1');
    $routes->get('table', 'EvaluasiRisikoController::ajaxTable');
    $routes->get('analisis-list', 'EvaluasiRisikoController::getAnalisisList');
    $routes->post('set-active', 'EvaluasiRisikoController::setActive');
    $routes->post('reset-active', 'EvaluasiRisikoController::resetActive');
    $routes->group('', function ($routes) {
        $routes->post('store', 'EvaluasiRisikoController::store');
        $routes->post('update/(:num)', 'EvaluasiRisikoController::update/$1');
        $routes->post('delete/(:num)', 'EvaluasiRisikoController::delete/$1');
    });
});
// Rencana Penanganan
$routes->group('rencana-penanganan', ['filter' => ['auth']], function ($routes) {
    $routes->get('/', 'RencanaPenangananController::index');
    $routes->post('set-active', 'RencanaPenangananController::setActive');
    $routes->post('reset-active', 'RencanaPenangananController::resetActive');
    $routes->post('store', 'RencanaPenangananController::store');
    $routes->post('update/(:num)', 'RencanaPenangananController::update/$1');
    $routes->post('delete/(:num)', 'RencanaPenangananController::delete/$1');
    $routes->get('detail/(:num)', 'RencanaPenangananController::detail/$1');
    $routes->get('detail-evaluasi/(:num)', 'RencanaPenangananController::detailEvaluasi/$1');
    $routes->get('kriteria-kemungkinan', 'RencanaPenangananController::getKriteriaKemungkinan');
    $routes->get('kriteria-dampak', 'RencanaPenangananController::getKriteriaDampak');
});

// Pemantauan
$routes->group('pemantauan-risiko', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PemantauanRisikoController::index');
    $routes->post('set-active', 'PemantauanRisikoController::setActive');
    $routes->post('reset-active', 'PemantauanRisikoController::resetActive');
    $routes->get('detail/(:num)', 'PemantauanRisikoController::detail/$1');
    $routes->post('store', 'PemantauanRisikoController::store');
    $routes->post('delete/(:num)', 'PemantauanRisikoController::delete/$1');
    $routes->delete('bukti/(:num)', 'PemantauanRisikoController::deleteBukti/$1');
    $routes->get('bukti/view/(:num)', 'PemantauanRisikoController::viewBukti/$1');
    $routes->get('bukti/download/(:num)', 'PemantauanRisikoController::downloadBukti/$1');
});

// Pelaporan (semua role)
$routes->group('pelaporan-risiko', ['filter' => ['auth']], function ($routes) {
    $routes->get('/', 'PelaporanRisikoController::index');
    $routes->post('set-active', 'PelaporanRisikoController::setActive');
    $routes->post('set-periode', 'PelaporanRisikoController::setPeriode');
    $routes->get('detail/(:num)', 'PelaporanRisikoController::detail/$1');
    $routes->post('approve/(:num)', 'PelaporanRisikoController::approve/$1');
    $routes->post('reject/(:num)', 'PelaporanRisikoController::reject/$1');
    $routes->post('validasi/(:num)', 'PelaporanRisikoController::validasi/$1');
    $routes->get('export', 'PelaporanRisikoController::export');
    $routes->get('print', 'PelaporanRisikoController::print');
});
