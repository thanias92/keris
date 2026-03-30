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
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran,
                p.nama as nama_pemilik,
                g.nama as nama_pengelola
            ')
            ->join('kegiatan', 'kegiatan.id_kegiatan = konteks.id_kegiatan', 'left')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja', 'left')
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
                konteks.id_satuan_kerja,
                konteks.id_kegiatan,
                konteks.pengelola_risiko_id,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran,
                kegiatan.nama_kegiatan,
                p.nama as nama_pemilik,
                g.nama as nama_pengelola
            ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja', 'left')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis', 'left')
            ->join('kegiatan', 'kegiatan.id_kegiatan = konteks.id_kegiatan', 'left')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
            ->orderBy('konteks.created_at', 'DESC')
            ->findAll();
    }

    /* ======================================================
       INDEX
    ====================================================== */
    public function index()
    {
        $activeKonteks = $this->getActiveKonteks();
        $idKonteks     = $activeKonteks ? $activeKonteks['id_konteks'] : null;
        $db            = \Config\Database::connect();

        /* PAGINATION CONFIG */
        $perPage = (int) ($this->request->getGet('perPage') ?? 5);
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
        if ($idKonteks) {
            $totalRisiko = $db->table('identifikasi_risiko ir')
                ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
                ->where('kpb.id_konteks', $idKonteks)
                ->countAllResults();

            $totalSudah = $db->table('identifikasi_risiko ir')
                ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
                ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi')
                ->join('evaluasi_risiko er', 'er.id_penilaian = pr.id_penilaian')
                ->where('kpb.id_konteks', $idKonteks)
                ->countAllResults();
        } else {
            $totalRisiko = $db->table('identifikasi_risiko')->countAllResults();
            $totalSudah  = $db->table('evaluasi_risiko')->countAllResults();
        }

        $totalBelum = $totalRisiko - $totalSudah;

        /* DISTRIBUSI LEVEL */
        $levelRisiko = [];

        $seleraList = $db->table('selera_risiko')
            ->select('nama_level, warna')
            ->orderBy('nilai_min', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($seleraList as $s) {
            $levelRisiko[$s['nama_level']] = [
                'jumlah' => 0,
                'warna'  => $s['warna']
            ];
        }

        $distribusiBuilder = $db->table('identifikasi_risiko ir')
            ->select('sl.nama_level, sl.warna, COUNT(*) as total')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera')
            ->groupBy('sl.nama_level, sl.warna');

        if ($idKonteks) {
            $distribusiBuilder->where('kpb.id_konteks', $idKonteks);
        }

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

    /* ======================================================
       SET / RESET ACTIVE KONTEKS
    ====================================================== */
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

    /* ======================================================
       DETAIL EVALUASI (AJAX — view/edit mode)
    ====================================================== */
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
                satuan_kerja.nama_satuan_kerja,
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
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = k.id_satuan_kerja', 'left')
            ->join('sasaran_strategis ss', 'ss.id_sasaran_strategis = k.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko g', 'g.id = k.pengelola_risiko_id', 'left')
            ->join('sasaran_kinerja sk_kinerja', 'sk_kinerja.id_konteks_proses = ir.id_konteks_proses', 'left')
            ->where('er.id_evaluasi', $id)
            ->get()->getRowArray();

        return $this->response->setJSON($data);
    }

    /* ======================================================
       DETAIL IDENTIFIKASI (AJAX — create mode)
    ====================================================== */
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
                satuan_kerja.nama_satuan_kerja,
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
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = k.id_satuan_kerja', 'left')
            ->join('sasaran_strategis ss', 'ss.id_sasaran_strategis = k.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko g', 'g.id = k.pengelola_risiko_id', 'left')
            ->join('sasaran_kinerja sk_kinerja', 'sk_kinerja.id_konteks_proses = ir.id_konteks_proses', 'left')
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->join('kriteria_kemungkinan km', 'km.id_kriteria = pr.id_kemungkinan', 'left')
            ->join('kriteria_dampak kd', 'kd.id_kriteria = pr.id_dampak', 'left')
            ->where('ir.id_identifikasi', $id)
            ->get()->getRowArray();

        return $this->response->setJSON($data);
    }

    /* ======================================================
       AJAX TABLE
    ====================================================== */
    public function ajaxTable()
    {
        $idKonteks = session('id_konteks_er');

        $builder = $this->db->table('identifikasi_risiko ir')
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
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->join('penilaian_risiko pr', 'pr.id_identifikasi = ir.id_identifikasi', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->join('evaluasi_risiko er', 'er.id_penilaian = pr.id_penilaian', 'left')
            ->orderBy('pb.kode_proses', 'ASC');

        if ($idKonteks) {
            $builder->where('kpb.id_konteks', $idKonteks);
        }

        $data = $builder->get()->getResultArray();

        return $this->response->setJSON($data);
    }

    /* ======================================================
       STORE
    ====================================================== */
    public function store()
    {
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

    /* ======================================================
       UPDATE
    ====================================================== */
    public function update($id)
    {
        try {
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

    /* ======================================================
       DELETE
    ====================================================== */
    public function delete($id)
    {
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

    /* ======================================================
       GET ANALISIS LIST (dropdown referensi)
    ====================================================== */
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
