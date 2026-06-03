<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\KonteksModel;
use App\Models\KonteksPemangkuModel;
use App\Models\KonteksPeraturanModel;
use App\Models\ProsesBisnisModel;
use App\Models\KonteksProsesBisnisModel;
use App\Models\PemangkuKepentinganModel;
use App\Models\PeraturanTerkaitModel;
use App\Models\TimKerjaModel;
use App\Models\SasaranStrategisModel;
use App\Models\PengelolaRisikoModel;
use App\Models\PenugasanPengelolaModel;
use App\Models\KegiatanModel;
use App\Models\WilayahModel;

class KonteksController extends BaseContextController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KonteksModel();
    }

    private function validateKonteksAccess($idKonteks): bool
    {
        $row = $this->model
            ->select('id_tim')
            ->where('id_konteks', $idKonteks)
            ->first();

        if (!$row) {
            return false;
        }

        $role = session('user_role');
        log_message('error', print_r([
            'role' => $role,
            'id_tim_session' => session('id_tim'),
            'id_konteks' => $idKonteks,
            'row' => $row,
        ], true));

        if ($role === 'admin') {
            return true;
        }

        if ($role === 'ketua') {
            return false;
        }

        return (string) session('id_tim')
            === (string) $row['id_tim'];
    }

    public function show($id)
    {
        $activeKonteks = $this->getActiveKonteks($id);      

        if (!$activeKonteks) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $listPemangku = (new PemangkuKepentinganModel())->findAll();
        $listPeraturan = (new PeraturanTerkaitModel())->findAll();
        $listTimKerja = (new TimKerjaModel())->findAll();
        $listSasaran = (new SasaranStrategisModel())->findAll();

        $listWilayah = (new WilayahModel())
            ->orderBy('nama_wilayah', 'ASC')
            ->findAll();

        $selectedProsesData = (new KonteksProsesBisnisModel())
            ->getByKonteks($id);

        $allProses = (new ProsesBisnisModel())
            ->orderBy('kode_proses', 'ASC')
            ->findAll();

        $sasaranOrganisasi = \Config\Database::connect()
            ->table('konteks_proses_bisnis kpb')
            ->select('
        kpb.id_konteks_proses,
        kpb.deskripsi_proses,
        pb.kode_proses,
        pb.jenis_proses,
        pb.uraian_proses,
        sk.id_sasaran,
        sk.uraian_sasaran
    ')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->join('sasaran_kinerja sk', 'sk.id_konteks_proses = kpb.id_konteks_proses', 'left')
            ->where('kpb.id_konteks', $id)
            ->orderBy('pb.kode_proses', 'ASC')
            ->get()
            ->getResultArray();

        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData($id),
                [
                    'activeTab'         => 'konteks',
                    'mode' => 'view',
                    'hideGlobalContext' => false,
                    'listPemangku'      => $listPemangku,
                    'listPeraturan'     => $listPeraturan,
                    'listTimKerja'      => $listTimKerja,
                    'listSasaran'       => $listSasaran,
                    'listWilayah'       => $listWilayah,
                    'allProses'         => $allProses,
                    'sasaranOrganisasi' => $sasaranOrganisasi,
                ]
            )
        );
    }

    public function redirectToActive()
    {
        $tahun      = session('global_tahun') ?? date('Y');
        $idTim      = session('global_id_tim') ?? session('id_tim');
        $idKegiatan = session('global_id_kegiatan');

        $builder = $this->model;

        // PRIORITAS 1
        // Jika selector sudah memilih kegiatan tertentu
        if (!empty($idKegiatan)) {

            $konteks = $builder
                ->where('tahun', $tahun)
                ->where('id_tim', $idTim)
                ->where('id_kegiatan', $idKegiatan)
                ->first();

            if ($konteks) {
                return redirect()->to(
                    site_url('penetapan-konteks/konteks/' . $konteks['id_konteks'])
                );
            }
        }

        // PRIORITAS 2
        // Cari ruang lingkup pertama yang tersedia
        $konteks = $builder
            ->where('tahun', $tahun)
            ->where('id_tim', $idTim)
            ->orderBy('id_kegiatan', 'ASC')
            ->first();

        if (!$konteks) {

            return redirect()
                ->to(site_url('penetapan-konteks'))
                ->with(
                    'warning',
                    'Belum ada Ruang Lingkup untuk tim dan tahun yang dipilih.'
                );
        }

        // Sinkronkan Global Context Selector
        session()->set([
            'global_tahun'       => $konteks['tahun'],
            'global_id_tim'      => $konteks['id_tim'],
            'global_id_kegiatan' => $konteks['id_kegiatan'],
        ]);

        return redirect()->to(
            site_url('penetapan-konteks/konteks/' . $konteks['id_konteks'])
        );
    }

    public function edit($id)
    {
        $activeKonteks = $this->getActiveKonteks($id);

        if (!$activeKonteks) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $listPemangku = (new PemangkuKepentinganModel())->findAll();
        $listPeraturan = (new PeraturanTerkaitModel())->findAll();
        $listTimKerja = (new TimKerjaModel())->findAll();
        $listSasaran = (new SasaranStrategisModel())->findAll();

        $listWilayah = (new WilayahModel())
            ->orderBy('nama_wilayah', 'ASC')
            ->findAll();

        $selectedProsesData = (new KonteksProsesBisnisModel())
            ->getByKonteks($id);

        $allProses = (new ProsesBisnisModel())
            ->orderBy('kode_proses', 'ASC')
            ->findAll();

        $sasaranOrganisasi = \Config\Database::connect()
            ->table('konteks_proses_bisnis kpb')
            ->select('
            kpb.id_konteks_proses,
            kpb.deskripsi_proses,
            pb.kode_proses,
            pb.jenis_proses,
            pb.uraian_proses,
            sk.id_sasaran,
            sk.uraian_sasaran
        ')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->join('sasaran_kinerja sk', 'sk.id_konteks_proses = kpb.id_konteks_proses', 'left')
            ->where('kpb.id_konteks', $id)
            ->orderBy('pb.kode_proses', 'ASC')
            ->get()
            ->getResultArray();

        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData($id),
                [
                    'activeTab'         => 'konteks',
                    'mode'              => 'edit',
                    'hideGlobalContext' => false,

                    'listPemangku'      => $listPemangku,
                    'listPeraturan'     => $listPeraturan,
                    'listTimKerja'      => $listTimKerja,
                    'listSasaran'       => $listSasaran,
                    'listWilayah'       => $listWilayah,

                    'allProses'         => $allProses,
                    'sasaranOrganisasi' => $sasaranOrganisasi,
                ]
            )
        );
    }

    /* INDEX (LOAD FULL PAGE) */
    public function index()
    {
        $listPemangku = (new PemangkuKepentinganModel())->findAll();
        $listPeraturan = (new PeraturanTerkaitModel())->findAll();
        $listTimKerja = (new TimKerjaModel())->findAll();
        $listSasaran = (new SasaranStrategisModel())->findAll();

        // FILTER
        $filterTahun  = $this->request->getGet('tahun');
        $filterTim    = $this->request->getGet('id_tim');
        $filterStatus = $this->request->getGet('status');

        $builder = $this->model
            ->select('
                konteks.*,
                tim_kerja.nama_tim,
                sasaran_strategis.uraian_sasaran,
                kegiatan.nama_kegiatan,
                p.nama as nama_pemilik,
                g.nama as nama_pengelola
            ')
            ->join('tim_kerja', 'tim_kerja.id_tim = konteks.id_tim', 'left')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis', 'left')
            ->join('kegiatan', 'kegiatan.id_kegiatan = konteks.id_kegiatan', 'left')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left');

        if (!empty($filterTahun)) {
            $builder->where('konteks.tahun', $filterTahun);
        }

        if (!empty($filterTim)) {
            $builder->where('konteks.id_tim', $filterTim);
        }

        if (!empty($filterStatus)) {

            if ($filterStatus === 'lengkap') {
                $builder->where('konteks.status', 'lengkap');
            }

            if ($filterStatus === 'draft') {
                $builder->groupStart()
                    ->where('konteks.status IS NULL', null, false)
                    ->orWhere('konteks.status !=', 'lengkap')
                    ->groupEnd();
            }
        }

        $perPage = (int) ($this->request->getGet('perPage') ?? 5);

        $data  = $builder->orderBy('tahun', 'DESC')->paginate($perPage);
        $pager = $this->model->pager;

        $total       = $pager->getTotal();
        $currentPage = $pager->getCurrentPage();
        $from        = ($currentPage - 1) * $perPage + 1;
        $to          = $from + count($data) - 1;

        if ($total == 0) {
            $from = 0;
            $to   = 0;
        }

        $listWilayah = (new WilayahModel())
            ->orderBy('nama_wilayah', 'ASC')
            ->findAll();

        $listTahun = $this->model
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'DESC')
            ->findAll();

        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData(),
                [
                    'activeTab'       => 'ruang_lingkup',
                    'data'            => $data,
                    'pager'           => $pager,
                    'from'            => $from,
                    'to'              => $to,
                    'total'           => $total,
                    'perPage'         => $perPage,
                    'listPemangku'    => $listPemangku,
                    'listPeraturan'   => $listPeraturan,
                    'listTimKerja' => $listTimKerja,
                    'listSasaran'     => $listSasaran,
                    'listWilayah'     => $listWilayah,
                    'listTahun' => $listTahun,
                    'filters' => [
                        'tahun'  => $filterTahun,
                        'id_tim' => $filterTim,
                        'status' => $filterStatus,
                    ],
                    'hideGlobalContext' => true,
                ]
            )
        );
    }

    public function createDraft()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $toInt = fn($v) => $v !== '' && $v !== null ? (int) $v : null;

        $data = [
            'tahun'       => (int) $this->request->getPost('tahun'),
            'id_tim'      => $toInt($this->request->getPost('id_tim')),
            'id_kegiatan' => $toInt($this->request->getPost('id_kegiatan')),
            'status'      => 'draft',
        ];
        $exists = $this->model
            ->where('tahun', $data['tahun'])
            ->where('id_kegiatan', $data['id_kegiatan'])
            ->first();

        if ($exists) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Kegiatan tersebut sudah memiliki ruang lingkup pada tahun yang sama.'
            ]);
        }

        $this->model->insert($data);

        $id = $this->model->getInsertID();
        session()->set([
            'global_tahun'       => $data['tahun'],
            'global_id_tim'      => $data['id_tim'],
            'global_id_kegiatan' => $data['id_kegiatan'],
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'id'     => $id,
        ]);
    }

    /* STORE (AJAX CREATE) */
    public function store()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $toInt = fn($v) => $v !== '' && $v !== null ? (int) $v : null;

        $data = [
            'tahun'                => (int) $this->request->getPost('tahun'),
            'pemilik_risiko_id'    => $toInt($this->request->getPost('pemilik_risiko_id')),
            'pengelola_risiko_id'  => $toInt($this->request->getPost('pengelola_risiko_id')),
            'id_kegiatan'          => $toInt($this->request->getPost('id_kegiatan')),
            'id_tim'               => $toInt($this->request->getPost('id_tim')),
            'id_sasaran_strategis' => $toInt($this->request->getPost('id_sasaran_strategis')),
        ];

        $db = \Config\Database::connect();
        $db->table('konteks')->insert($data);
        $idKonteks = $db->insertID();

        // SIMPAN PEMANGKU
        $pemangkuModel = new KonteksPemangkuModel();
        foreach ($this->request->getPost('pemangku') ?? [] as $idPemangku) {
            $pemangkuModel->insert(['id_konteks' => $idKonteks, 'id_pemangku' => $idPemangku]);
        }

        // SIMPAN PERATURAN
        $peraturanModel = new KonteksPeraturanModel();
        foreach ($this->request->getPost('peraturan') ?? [] as $idPeraturan) {
            $peraturanModel->insert(['id_konteks' => $idKonteks, 'id_peraturan' => $idPeraturan]);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil disimpan']);
    }

    /* UPDATE (AJAX EDIT) */
    public function update()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $id    = $this->request->getPost('id_konteks');
        if (!$this->validateKonteksAccess($id)) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak punya akses'
                ]);
        }

        $toInt = fn($v) => $v !== '' && $v !== null ? (int) $v : null;

        $data = [
            'tahun'                => (int) $this->request->getPost('tahun'),
            'pengelola_risiko_id'  => $toInt($this->request->getPost('pengelola_risiko_id')),
            'pemilik_risiko_id'    => $toInt($this->request->getPost('pemilik_risiko_id')),
            'id_kegiatan'          => $toInt($this->request->getPost('id_kegiatan')),
            'id_tim'               => $toInt($this->request->getPost('id_tim')),
            'id_sasaran_strategis' => $toInt($this->request->getPost('id_sasaran_strategis')),
        ];

        $db = \Config\Database::connect();
        $db->table('konteks')->where('id_konteks', (int) $id)->update($data);

        // UPDATE PEMANGKU
        $pemangkuModel = new KonteksPemangkuModel();
        $pemangkuModel->where('id_konteks', $id)->delete();
        foreach ($this->request->getPost('pemangku') ?? [] as $idPemangku) {
            $pemangkuModel->insert(['id_konteks' => $id, 'id_pemangku' => $idPemangku]);
        }

        // UPDATE PERATURAN
        $peraturanModel = new KonteksPeraturanModel();
        $peraturanModel->where('id_konteks', $id)->delete();
        foreach ($this->request->getPost('peraturan') ?? [] as $idPeraturan) {
            $peraturanModel->insert(['id_konteks' => $id, 'id_peraturan' => $idPeraturan]);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /* DELETE (AJAX) */
    public function delete()
    {
        $id = $this->request->getPost('id_konteks');

        if (!$this->validateKonteksAccess($id)) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak punya akses'
                ]);
        }
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $this->model->delete($this->request->getPost('id_konteks'));

        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }

    /* AJAX TABLE REFRESH */
    public function ajaxTable()
    {
        $data = $this->model
            ->select('
                konteks.*,
                kegiatan.nama_kegiatan,
                tim_kerja.nama_tim,
                sasaran_strategis.uraian_sasaran,
                p.nama as nama_pemilik,
                g.nama as nama_pengelola
            ')
            ->join('kegiatan', 'kegiatan.id_kegiatan = konteks.id_kegiatan', 'left')
            ->join('tim_kerja', 'tim_kerja.id_tim = konteks.id_tim', 'left')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
            ->orderBy('tahun', 'DESC')
            ->findAll();

        return view('penetapan_konteks/tabs/ruang_lingkup/_table_section', [
            'data'    => $data,
            'from'    => 1,
            'to'      => count($data),
            'total'   => count($data),
            'filters' => [],
            'perPage' => 5,
        ]);
    }

    /* SET ACTIVE */
    public function setActive()
    {
        $id = $this->request->getPost('id_konteks');
        if (!$id) return redirect()->back();
        session()->set('id_konteks_aktif', $id);
        $redirect = $this->request->getPost('redirect') ?? site_url('penetapan-konteks');
        return redirect()->to($redirect);
    }

    public function detail($id)
    {
        if (!$this->request->isAJAX()) return redirect()->back();

        $konteks = $this->model
            ->select('konteks.*, kegiatan.nama_kegiatan, tim_kerja.nama_tim, sasaran_strategis.uraian_sasaran, wilayah.nama_wilayah, wilayah.tipe')
            ->join('kegiatan', 'kegiatan.id_kegiatan = konteks.id_kegiatan', 'left')
            ->join('tim_kerja', 'tim_kerja.id_tim = konteks.id_tim', 'left')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
            ->join('wilayah', 'wilayah.id = p.wilayah_id', 'left')
            ->where('konteks.id_konteks', $id)
            ->first();

        $pemangku  = (new KonteksPemangkuModel())->select('id_pemangku')->where('id_konteks', $id)->findAll();
        $peraturan = (new KonteksPeraturanModel())->select('id_peraturan')->where('id_konteks', $id)->findAll();

        // Ambil sasaran kinerja untuk konteks ini
        $db = \Config\Database::connect();
        $sasaranKinerja = $db->table('sasaran_kinerja sk')
            ->select('sk.uraian_sasaran, pb.kode_proses, pb.jenis_proses, pb.uraian_proses')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = sk.id_konteks_proses')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->where('kpb.id_konteks', $id)
            ->orderBy('pb.kode_proses', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'konteks'        => $konteks,
            'pemangku'       => array_column($pemangku, 'id_pemangku'),
            'peraturan'      => array_column($peraturan, 'id_peraturan'),
            'sasaranKinerja' => $sasaranKinerja,
        ]);
    }

    /* GET PEMILIK PROVINSI (AJAX) */
    public function getPemilikProvinsi()
    {
        $data = (new PengelolaRisikoModel())
            ->where('is_pemilik', true)
            ->first();

        return $this->response->setJSON($data);
    }
    /* GET PENGELOLA LIST BY SATUAN KERJA & TAHUN (AJAX)
       → sekarang pakai penugasan_pengelola */
    public function getPengelolaList()
    {
        $id_tim = (int) $this->request->getGet('tim');
        $tahun  = (int) ($this->request->getGet('tahun') ?? date('Y'));

        if (!$id_tim) {
            return $this->response->setJSON([]);
        }

        $db = \Config\Database::connect();

        // ambil ketua tim sesuai tahun
        $data = $db->table('penugasan_pengelola pp')
            ->select('
            pr.id,
            pr.nama,
            pr.nip,
            pr.jabatan,
            pp.tahun
        ')
            ->join('pengelola_risiko pr', 'pr.id = pp.pengelola_id')
            ->where('pp.tim_kerja_id', $id_tim)
            ->where('pp.tahun', $tahun)
            ->where('pp.is_ketua_tim', true)
            ->orderBy('pp.id', 'DESC')
            ->get()
            ->getRowArray();

        // fallback tahun lain
        if (!$data) {
            $data = $db->table('penugasan_pengelola pp')
                ->select('
                pr.id,
                pr.nama,
                pr.nip,
                pr.jabatan,
                pp.tahun
            ')
                ->join('pengelola_risiko pr', 'pr.id = pp.pengelola_id')
                ->where('pp.tim_kerja_id', $id_tim)
                ->where('pp.is_ketua_tim', true)
                ->orderBy('pp.tahun', 'DESC')
                ->get()
                ->getRowArray();

            if ($data) {
                $data['is_fallback'] = true;
            }
        }

        return $this->response->setJSON($data ?? []);
    }
    /* GET KEGIATAN BY TIM KERJA (AJAX) */
    public function getKegiatanByTim($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $tahun = $this->request->getGet('tahun');

        $usedKegiatan = [];

        if ($tahun) {
            $usedKegiatan = $this->model
                ->where('tahun', $tahun)
                ->findColumn('id_kegiatan');
        }

        $builder = (new KegiatanModel())
            ->where('id_tim', $id);

        if (!empty($usedKegiatan)) {
            $builder->whereNotIn('id_kegiatan', $usedKegiatan);
        }

        $data = $builder
            ->orderBy('nama_kegiatan', 'ASC')
            ->findAll();

        log_message('error', json_encode([
            'tahun' => $tahun,
            'usedKegiatan' => $usedKegiatan,
            'data' => $data
        ]));

        return $this->response->setJSON($data);
    }

    public function resetActive()
    {
        session()->remove('id_konteks_aktif');
        $redirect = $this->request->getPost('redirect') ?? site_url('penetapan-konteks/proses-bisnis');
        return redirect()->to($redirect);
    }
}
