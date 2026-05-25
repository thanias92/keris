<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EvaluasiRisikoModel;
use App\Models\KonteksModel;

class EvaluasiRisikoController extends BaseController
{
    protected $evaluasiModel;
    protected $db;

    public function __construct()
    {
        $this->evaluasiModel = new EvaluasiRisikoModel();
        $this->db            = \Config\Database::connect();
    }

    private function getActiveKonteks(): ?array
    {
        $id = session('id_konteks_er');
        if (!$id) return null;

        $data = (new KonteksModel())
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
            ->where('konteks.id_konteks', $id)
            ->first();

        if (!$data) {
            session()->remove('id_konteks_er');
            return null;
        }

        return $data;
    }

    private function getListKonteks(): array
    {
        return (new KonteksModel())
            ->select('
                konteks.id_konteks,
                konteks.tahun,
                konteks.id_tim,
                konteks.id_kegiatan,
                konteks.pengelola_risiko_id,
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
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
            ->orderBy('konteks.created_at', 'DESC')
            ->findAll();
    }

    private function validateTimAccessByIdentifikasi($idIdentifikasi): bool
    {
        $db = \Config\Database::connect();

        $row = $db->table('identifikasi_risiko ir')
            ->select('k.id_tim')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->where('ir.id_identifikasi', $idIdentifikasi)
            ->get()
            ->getRow();

        if (!$row) return false;

        $role = session('role');
        if ($role === 'admin') return true;
        if ($role === 'ketua') return true;

        return (string)session('id_tim') === (string)$row->id_tim;
    }

    public function index()
    {
        $idKonteks = $this->request->getGet('id_konteks');

        if ($idKonteks) {
            session()->set('id_konteks_er', $idKonteks);
        } else {
            $idKonteks = session('id_konteks_er');
        }

        $idTim = $this->request->getGet('sk')
            ?? session('global_id_tim');

        $idKegiatan = $this->request->getGet('kg')
            ?? session('global_id_kegiatan');

        $tahun = $this->request->getGet('th')
            ?? session('global_tahun');

        $idPengelola = $this->request->getGet('pg');

        $activeKonteks = $this->getActiveKonteks();

        if ($idKonteks) {
            $activeKonteks = (new KonteksModel())->find($idKonteks);
        }

        if (!$activeKonteks && $idTim) {
            $activeKonteks = [
                'id_tim' => $idTim
            ];
        }
        $db            = \Config\Database::connect();

        /* PAGINATION CONFIG */
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $offset  = ($page - 1) * $perPage;

        /* QUERY UTAMA */
        $builder = $db->table('identifikasi_risiko ir')
            ->select('
                ir.id_identifikasi,
                ir.pernyataan_risiko,
                ir.penyebab_risiko,
                ir.dampak_risiko,
                kpb.id_konteks,
                kpb.id_konteks_proses,
                pb.kode_proses,
                pb.uraian_proses,
                pb.jenis_proses,
                sk_kinerja.uraian_sasaran as sasaran_kinerja,
                pr.id_penilaian,
                pr.nilai_risiko,
                pr.warna_risiko,
                pr.tindakan,
                pr.efektivitas,
                pr.uraian_pengendalian,
                km.level as level_kemungkinan,
                km.nama_level as nama_kemungkinan,
                kd.level as level_dampak,
                kd.nama_level as nama_dampak,
                sl.nama_level as nama_selera,
                sl.warna as warna_selera,
                er.id_evaluasi,
                er.opsi_tindakan,
                er.prioritas,
                er.keterangan,
                er.status_evaluasi
            ')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->join('sasaran_kinerja sk_kinerja', 'sk_kinerja.id_konteks_proses = ir.id_konteks_proses', 'left')
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi', 'left')
            ->join('kriteria_kemungkinan km', 'km.id_kriteria = pr.id_kemungkinan', 'left')
            ->join('kriteria_dampak kd', 'kd.id_kriteria = pr.id_dampak', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->join('evaluasi_risiko er', 'er.id_penilaian = pr.id_penilaian', 'left');

        if ($idKonteks) {
            $builder->where('kpb.id_konteks', $idKonteks);
        }

        if ($idTim) {
            $builder->where('k.id_tim', $idTim);
        }

        if ($idPengelola) {
            $builder->where('k.pengelola_risiko_id', $idPengelola);
        }

        if ($idKegiatan) {
            $builder->where('k.id_kegiatan', $idKegiatan);
        }

        if ($tahun) {
            $builder->where('k.tahun', $tahun);
        }

        $filter = $this->request->getGet('filter');
        if ($filter === 'sudah') {
            $builder->where('er.id_evaluasi IS NOT NULL', null, false);
        } elseif ($filter === 'belum') {
            $builder->where('er.id_evaluasi IS NULL', null, false);
        }

        $builder->orderBy('pb.kode_proses', 'ASC');

        /* TOTAL & PAGINATED DATA */
        $total = $builder->countAllResults(false);
        $data  = $builder->limit($perPage, $offset)->get()->getResultArray();

        $from = $total > 0 ? $offset + 1 : 0;
        $to   = min($offset + $perPage, $total);

        /* MANUAL PAGER */
        $totalPages = (int) ceil($total / $perPage);
        $pager = [
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'perPage'     => $perPage,
            'total'       => $total,
            'filter'      => $filter,
        ];

        /* SUMMARY */
        $summaryBuilder = $db->table('identifikasi_risiko ir')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks');

        if ($idTim) $summaryBuilder->where('k.id_tim', $idTim);
        if ($idPengelola) $summaryBuilder->where('k.pengelola_risiko_id', $idPengelola);
        if ($idKegiatan) $summaryBuilder->where('k.id_kegiatan', $idKegiatan);
        if ($tahun) $summaryBuilder->where('k.tahun', $tahun);
        if ($idKonteks) {
            $summaryBuilder->where('kpb.id_konteks', $idKonteks);
        }

        $totalRisiko = $summaryBuilder->countAllResults();

        // rebuild ulang
        $summaryBuilder = $db->table('identifikasi_risiko ir')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks');

        if ($idTim) $summaryBuilder->where('k.id_tim', $idTim);
        if ($idPengelola) $summaryBuilder->where('k.pengelola_risiko_id', $idPengelola);
        if ($idKegiatan) $summaryBuilder->where('k.id_kegiatan', $idKegiatan);
        if ($tahun) $summaryBuilder->where('k.tahun', $tahun);
        if ($idKonteks) {
            $summaryBuilder->where('kpb.id_konteks', $idKonteks);
        }

        $totalSudah = $summaryBuilder
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi')
            ->join('evaluasi_risiko er', 'er.id_penilaian = pr.id_penilaian')
            ->countAllResults();

        $totalBelum = $totalRisiko - $totalSudah;

        /* DISTRIBUSI LEVEL */
        $levelRisiko = [
            'Sangat Rendah' => ['jumlah' => 0],
            'Rendah'        => ['jumlah' => 0],
            'Sedang'        => ['jumlah' => 0],
            'Tinggi'        => ['jumlah' => 0],
            'Sangat Tinggi' => ['jumlah' => 0],
        ];
        $distribusiBuilder = $db->table('identifikasi_risiko ir')
            ->select('sl.nama_level, COUNT(*) as total')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->where('sl.nama_level IS NOT NULL', null, false)
            ->groupBy('sl.nama_level');

        if ($idKonteks) {
            $distribusiBuilder->where('kpb.id_konteks', $idKonteks);
        }
        if ($idTim) $distribusiBuilder->where('k.id_tim', $idTim);
        if ($idPengelola) $distribusiBuilder->where('k.pengelola_risiko_id', $idPengelola);
        if ($idKegiatan) $distribusiBuilder->where('k.id_kegiatan', $idKegiatan);
        if ($tahun) $distribusiBuilder->where('k.tahun', $tahun);

        foreach ($distribusiBuilder->get()->getResultArray() as $row) {
            if (isset($levelRisiko[$row['nama_level']])) {
                $levelRisiko[$row['nama_level']]['jumlah'] = (int)$row['total'];
            }
        }

        return view('evaluasi_risiko/index', [
            'data'          => $data,
            'listKonteks'   => $this->getListKonteks(),
            'activeKonteks' => $activeKonteks,
            'totalRisiko'   => $totalRisiko,
            'totalSudah'    => $totalSudah,
            'totalBelum'    => $totalBelum,
            'levelRisiko'   => $levelRisiko,
            'filter'        => $filter,
            'total'         => $total,
            'from'          => $from,
            'to'            => $to,
            'perPage'       => $perPage,
            'pager'         => $pager,
        ]);
    }

    public function setActive()
    {
        $id = $this->request->getPost('id_konteks');
        if (!$id) return redirect()->back();
        session()->set('id_konteks_er', $id);
        return redirect()->to(site_url('evaluasi-risiko'));
    }

    public function resetActive()
    {
        session()->remove('id_konteks_er');
        return redirect()->to(site_url('evaluasi-risiko'));
    }

    /* DETAIL EVALUASI (AJAX — view/edit mode) */
    public function detail($id)
    {
        $data = $this->db->table('evaluasi_risiko er')
            ->select('
                er.*,
                ir.pernyataan_risiko,
                ir.penyebab_risiko,
                ir.dampak_risiko,
                ir.id_konteks_proses,
                kpb.id_konteks,
                pb.kode_proses,
                pb.uraian_proses,
                sk_kinerja.uraian_sasaran as sasaran_kinerja,
                k.tahun,
                k.id_tim,
                tim_kerja.nama_tim,
                ss.uraian_sasaran as sasaran_strategis,
                g.nama as nama_pengelola,
                pr.nilai_risiko,
                pr.warna_risiko,
                pr.tindakan as tindakan_selera,
                pr.efektivitas,
                pr.uraian_pengendalian,
                km.level as level_kemungkinan,
                kd.level as level_dampak,
                sl.nama_level as nama_selera
            ')
            ->join('identifikasi_risiko ir', 'ir.id_identifikasi = er.id_identifikasi')
            ->join('penilaian_risiko pr', 'pr.id_penilaian = er.id_penilaian', 'left')
            ->join('kriteria_kemungkinan km', 'km.id_kriteria = pr.id_kemungkinan', 'left')
            ->join('kriteria_dampak kd', 'kd.id_kriteria = pr.id_dampak', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('tim_kerja', 'tim_kerja.id_tim = k.id_tim', 'left')
            ->join('sasaran_strategis ss', 'ss.id_sasaran_strategis = k.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko g', 'g.id = k.pengelola_risiko_id', 'left')
            ->join('sasaran_kinerja sk_kinerja', 'sk_kinerja.id_konteks_proses = ir.id_konteks_proses', 'left')
            ->where('er.id_evaluasi', $id)
            ->get()->getRowArray();
        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return $this->response->setJSON($data);
    }

    /* DETAIL IDENTIFIKASI (AJAX — create mode) */
    public function detailAnalisis($id)
    {
        $data = $this->db->table('identifikasi_risiko ir')
            ->select('
                ir.*,
                kpb.id_konteks,
                pb.kode_proses,
                pb.uraian_proses,
                sk_kinerja.uraian_sasaran as sasaran_kinerja,
                k.tahun,
                k.id_tim,
                tim_kerja.nama_tim,
                ss.uraian_sasaran as sasaran_strategis,
                g.nama as nama_pengelola,
                pr.id_penilaian,
                pr.nilai_risiko,
                pr.warna_risiko,
                pr.tindakan as tindakan_selera,
                pr.efektivitas,
                pr.uraian_pengendalian,
                sl.nama_level as nama_selera,
                sl.warna as warna_selera,
                km.level as level_kemungkinan,
                km.nama_level as nama_kemungkinan,
                kd.level as level_dampak,
                kd.nama_level as nama_dampak
            ')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('tim_kerja', 'tim_kerja.id_tim = k.id_tim', 'left')
            ->join('sasaran_strategis ss', 'ss.id_sasaran_strategis = k.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko g', 'g.id = k.pengelola_risiko_id', 'left')
            ->join('sasaran_kinerja sk_kinerja', 'sk_kinerja.id_konteks_proses = ir.id_konteks_proses', 'left')
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->join('kriteria_kemungkinan km', 'km.id_kriteria = pr.id_kemungkinan', 'left')
            ->join('kriteria_dampak kd', 'kd.id_kriteria = pr.id_dampak', 'left')
            ->where('ir.id_identifikasi', $id)
            ->get()->getRowArray();
        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return $this->response->setJSON($data);
    }

    /* AJAX TABLE */
    public function ajaxTable()
    {
        if (!$this->request->isAJAX()) return redirect()->back();

        $db = \Config\Database::connect();

        $idKonteks = $this->request->getGet('id_konteks');

        if ($idKonteks) {
            session()->set('id_konteks_er', $idKonteks);
        } else {
            $idKonteks = session('id_konteks_er');
        }

        $idTim        = $this->request->getGet('sk');
        $idPengelola  = $this->request->getGet('pg');
        $idKegiatan   = $this->request->getGet('kg');
        $tahun        = $this->request->getGet('th');

        /* =======================
       QUERY TABLE
    ======================= */
        $builder = $db->table('identifikasi_risiko ir')
            ->select('
            ir.id_identifikasi,
            ir.pernyataan_risiko,
            pb.kode_proses,
            pb.uraian_proses,
            pr.id_penilaian,
            pr.nilai_risiko,
            pr.warna_risiko,
            sl.nama_level as nama_selera,
            er.id_evaluasi,
            er.opsi_tindakan,
            er.prioritas,
            er.status_evaluasi
        ')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->join('evaluasi_risiko er', 'er.id_penilaian = pr.id_penilaian', 'left')
            ->orderBy('pb.kode_proses', 'ASC');

        if ($idKonteks) $builder->where('kpb.id_konteks', $idKonteks);
        if ($idTim) $builder->where('k.id_tim', $idTim);
        if ($idPengelola) $builder->where('k.pengelola_risiko_id', $idPengelola);
        if ($idKegiatan) $builder->where('k.id_kegiatan', $idKegiatan);
        if ($tahun) $builder->where('k.tahun', $tahun);

        $filter = $this->request->getGet('filter');
        if ($filter === 'sudah') {
            $builder->where('er.id_evaluasi IS NOT NULL', null, false);
        } elseif ($filter === 'belum') {
            $builder->where('er.id_evaluasi IS NULL', null, false);
        }

        /* PAGINATION */
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $offset  = ($page - 1) * $perPage;

        $total = $builder->countAllResults(false);
        $data  = $builder->limit($perPage, $offset)->get()->getResultArray();

        $from = $total > 0 ? $offset + 1 : 0;
        $to   = min($offset + $perPage, $total);

        /* =======================
       SUMMARY
    ======================= */
        $summaryBuilder = $db->table('identifikasi_risiko ir')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks');

        if ($idKonteks) $summaryBuilder->where('kpb.id_konteks', $idKonteks);
        if ($idTim) $summaryBuilder->where('k.id_tim', $idTim);
        if ($idPengelola) $summaryBuilder->where('k.pengelola_risiko_id', $idPengelola);
        if ($idKegiatan) $summaryBuilder->where('k.id_kegiatan', $idKegiatan);
        if ($tahun) $summaryBuilder->where('k.tahun', $tahun);

        $totalRisiko = $summaryBuilder->countAllResults();

        // rebuild
        $summaryBuilder = $db->table('identifikasi_risiko ir')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks');

        if ($idKonteks) $summaryBuilder->where('kpb.id_konteks', $idKonteks);
        if ($idTim) $summaryBuilder->where('k.id_tim', $idTim);
        if ($idPengelola) $summaryBuilder->where('k.pengelola_risiko_id', $idPengelola);
        if ($idKegiatan) $summaryBuilder->where('k.id_kegiatan', $idKegiatan);
        if ($tahun) $summaryBuilder->where('k.tahun', $tahun);

        $totalSudah = $summaryBuilder
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi')
            ->join('evaluasi_risiko er', 'er.id_penilaian = pr.id_penilaian')
            ->countAllResults();

        $totalBelum = $totalRisiko - $totalSudah;

        /* =======================
       DISTRIBUSI LEVEL (SAMA SEPERTI ANALISIS)
    ======================= */
        $levelRisiko = [
            'Sangat Rendah' => ['jumlah' => 0],
            'Rendah'        => ['jumlah' => 0],
            'Sedang'        => ['jumlah' => 0],
            'Tinggi'        => ['jumlah' => 0],
            'Sangat Tinggi' => ['jumlah' => 0],
        ];

        $distribusiBuilder = $db->table('identifikasi_risiko ir')
            ->select('sl.nama_level, COUNT(*) as total')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->where('sl.nama_level IS NOT NULL', null, false)
            ->groupBy('sl.nama_level');

        if ($idKonteks) $distribusiBuilder->where('kpb.id_konteks', $idKonteks);
        if ($idTim) $distribusiBuilder->where('k.id_tim', $idTim);
        if ($idPengelola) $distribusiBuilder->where('k.pengelola_risiko_id', $idPengelola);
        if ($idKegiatan) $distribusiBuilder->where('k.id_kegiatan', $idKegiatan);
        if ($tahun) $distribusiBuilder->where('k.tahun', $tahun);

        foreach ($distribusiBuilder->get()->getResultArray() as $row) {
            if (isset($levelRisiko[$row['nama_level']])) {
                $levelRisiko[$row['nama_level']] = (int)$row['total'];
            }
        }

        return view('evaluasi_risiko/_table_section', [
            'data'          => $data,
            'total'         => $total,
            'from'          => $from,
            'to'            => $to,
            'perPage'       => $perPage,

            // summary (WAJIB supaya sync dengan Analisis)
            'totalRisiko'   => $totalRisiko,
            'totalSudah'    => $totalSudah,
            'totalBelum'    => $totalBelum,
            'levelRisiko'   => $levelRisiko,
            'filter'        => $filter,
        ]);
    }

    public function store()
    {
        $idIdentifikasi = $this->request->getPost('id_identifikasi');

        if (!$this->validateTimAccessByIdentifikasi($idIdentifikasi)) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Tidak punya akses ke data ini'
            ]);
        }
        try {
            $opsiTindakan = $this->request->getPost('opsi_tindakan');

            $this->evaluasiModel->insert([
                'id_identifikasi' => $this->request->getPost('id_identifikasi'),
                'id_penilaian'    => $this->request->getPost('id_penilaian'),
                'opsi_tindakan'   => $opsiTindakan,
                'prioritas'       => ($opsiTindakan === 'Mengurangi Risiko')
                    ? $this->request->getPost('prioritas')
                    : null,
                'keterangan'      => $this->request->getPost('keterangan'),
                'status_evaluasi' => 'draft',
            ]);

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'Evaluasi risiko berhasil disimpan',
                'csrf_token' => csrf_hash(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'ER Store Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update($id)
    {
        try {
            $data = $this->evaluasiModel->find($id);

            if (!$data || !$this->validateTimAccessByIdentifikasi($data['id_identifikasi'])) {
                return $this->response->setStatusCode(403)->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak punya akses'
                ]);
            }
            $opsiTindakan = $this->request->getPost('opsi_tindakan');

            $this->evaluasiModel->update($id, [
                'id_identifikasi' => $this->request->getPost('id_identifikasi'),
                'id_penilaian'    => $this->request->getPost('id_penilaian'),
                'opsi_tindakan'   => $opsiTindakan,
                'prioritas'       => ($opsiTindakan === 'Mengurangi Risiko')
                    ? $this->request->getPost('prioritas')
                    : null,
                'keterangan'      => $this->request->getPost('keterangan'),
            ]);

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'Evaluasi risiko berhasil diperbarui',
                'csrf_token' => csrf_hash(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'ER Update Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        $data = $this->evaluasiModel->find($id);

        if (!$data || !$this->validateTimAccessByIdentifikasi($data['id_identifikasi'])) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Tidak punya akses'
            ]);
        }
        try {
            $this->db->transStart();

            // Hapus RTP dulu sebelum hapus evaluasi
            $this->db->table('rencana_penanganan_risiko')
                ->where('id_penilaian_awal', $id)
                ->delete();

            $this->evaluasiModel->delete($id);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaksi gagal.');
            }

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'Data berhasil dihapus',
                'csrf_token' => csrf_hash(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'ER Delete Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /* GET ANALISIS LIST (dropdown referensi) */
    public function getAnalisisList()
    {
        $idKonteks = session('id_konteks_er');

        $builder = $this->db->table('penilaian_risiko pr')
            ->select('
                pr.id_penilaian,
                pr.nilai_risiko,
                pr.warna_risiko,
                ir.id_identifikasi,
                ir.pernyataan_risiko,
                sl.nama_level as nama_selera
            ')
            ->join('identifikasi_risiko ir', 'ir.id_identifikasi = pr.id_identifikasi', 'left')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->orderBy('pr.id_penilaian', 'DESC');

        if ($idKonteks) {
            $builder->where('kpb.id_konteks', $idKonteks);
        }

        return $this->response->setJSON($builder->get()->getResultArray());
    }
}
