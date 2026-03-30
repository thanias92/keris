<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RencanaPenangananRisikoModel;
use App\Models\KonteksModel;

class RencanaPenangananController extends BaseController
{
    protected $rtpModel;
    protected $db;

    public function __construct()
    {
        $this->rtpModel = new RencanaPenangananRisikoModel();
        $this->db       = \Config\Database::connect();
    }

    /* ======================================================
       ACTIVE KONTEKS
    ====================================================== */
    private function getActiveKonteks(): ?array
    {
        $id = session('id_konteks_rtp');
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
            ->join('kegiatan',           'kegiatan.id_kegiatan = konteks.id_kegiatan', 'left')
            ->join('satuan_kerja',       'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja', 'left')
            ->join('sasaran_strategis',  'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
            ->where('konteks.id_konteks', $id)
            ->first();

        if (!$data) {
            session()->remove('id_konteks_rtp');
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
            ->join('satuan_kerja',       'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja', 'left')
            ->join('sasaran_strategis',  'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis', 'left')
            ->join('kegiatan',           'kegiatan.id_kegiatan = konteks.id_kegiatan', 'left')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
            ->orderBy('konteks.created_at', 'DESC')
            ->findAll();
    }

    /* ======================================================
       KRITERIA (dipakai index() dan offcanvas)
    ====================================================== */
    private function getKriteriaList(): array
    {
        return [
            'kriteriaKemungkinan' => $this->db->table('kriteria_kemungkinan')
                ->select('id_kriteria, level, nama_level')
                ->orderBy('level', 'ASC')
                ->get()->getResultArray(),

            'kriteriaDampak' => $this->db->table('kriteria_dampak')
                ->select('id_kriteria, level, nama_level')
                ->orderBy('level', 'ASC')
                ->get()->getResultArray(),
        ];
    }

    /* ======================================================
       SUMMARY STATS
    ====================================================== */
    private function getSummary(?int $idKonteks): array
    {
        /* TOTAL risiko ber-opsi Mengurangi */
        $qTotal = $this->db->table('evaluasi_risiko er')
            ->join('identifikasi_risiko ir',    'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->where('er.opsi_tindakan', 'Mengurangi');
        if ($idKonteks) $qTotal->where('kpb.id_konteks', $idKonteks);
        $totalRisiko = $qTotal->countAllResults();

        /* SUDAH ada RTP */
        $totalSudah = (int) $this->db->query("
    SELECT COUNT(*) as total
    FROM (
        SELECT DISTINCT er.id_evaluasi
        FROM evaluasi_risiko er
        JOIN identifikasi_risiko ir        ON ir.id_identifikasi = er.id_identifikasi
        JOIN konteks_proses_bisnis kpb     ON kpb.id_konteks_proses = ir.id_konteks_proses
        JOIN rencana_penanganan_risiko rtp ON rtp.id_penilaian_awal = er.id_evaluasi
        WHERE er.opsi_tindakan = 'Mengurangi'
        " . ($idKonteks ? "AND kpb.id_konteks = $idKonteks" : "") . "
    ) as sub
")->getRowArray()['total'] ?? 0;
        $totalBelum = $totalRisiko - $totalSudah;

        /* DISTRIBUSI LEVEL RISIKO */
        $levelRisiko       = ['Rendah' => 0, 'Sedang' => 0, 'Tinggi' => 0, 'Ekstrem' => 0];
        $qDistribusi = $this->db->table('evaluasi_risiko er')
            ->select('sl.nama_level, COUNT(*) as total')
            ->join('identifikasi_risiko ir',    'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('penilaian_risiko pr',       'pr.id_penilaian = er.id_penilaian', 'left')
            ->join('selera_risiko sl',          'sl.id_selera = pr.id_selera', 'left')
            ->where('er.opsi_tindakan', 'Mengurangi')
            ->groupBy('sl.nama_level');
        if ($idKonteks) $qDistribusi->where('kpb.id_konteks', $idKonteks);

        foreach ($qDistribusi->get()->getResultArray() as $row) {
            if (isset($levelRisiko[$row['nama_level']])) {
                $levelRisiko[$row['nama_level']] = (int) $row['total'];
            }
        }

        return compact('totalRisiko', 'totalSudah', 'totalBelum', 'levelRisiko');
    }

    /* ======================================================
       INDEX
    ====================================================== */
    public function index()
    {
        $activeKonteks = $this->getActiveKonteks();
        $idKonteks     = $activeKonteks ? (int) $activeKonteks['id_konteks'] : null;

        /* PAGINATION */
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $page    = (int) ($this->request->getGet('page')    ?? 1);
        $offset  = ($page - 1) * $perPage;
        $filter  = $this->request->getGet('filter');

        /* QUERY UTAMA */
        $builder = $this->db->table('evaluasi_risiko er')
            ->select('
                er.id_evaluasi,
                er.opsi_tindakan,
                er.keterangan as keterangan_evaluasi,
                ir.id_identifikasi,
                ir.pernyataan_risiko,
                ir.penyebab_risiko,
                ir.dampak_risiko,
                kpb.id_konteks,
                pb.kode_proses,
                pb.uraian_proses,
                sk.nama_satuan_kerja,
                pr.id_penilaian,
                pr.nilai_risiko,
                pr.warna_risiko,
                km.level      as level_kemungkinan,
                kd.level      as level_dampak,
                sl.nama_level as nama_selera,
                sl.warna as warna_selera,
                rtp.id_rtp,
                rtp.uraian_rtp,
                rtp.target_output,
                rtp.target_waktu,
                rtp.id_kemungkinan_residu,
                rtp.id_dampak_residu,
                km_r.level      as level_kemungkinan_residu,
                km_r.nama_level as nama_kemungkinan_residu,
                kd_r.level      as level_dampak_residu,
                kd_r.nama_level as nama_dampak_residu
            ')
            ->join('identifikasi_risiko ir',       'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb',    'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('proses_bisnis pb',             'pb.id_proses = kpb.id_proses')
            ->join('konteks k',                    'k.id_konteks = kpb.id_konteks')
            ->join('satuan_kerja sk',              'sk.id_satuan_kerja = k.id_satuan_kerja', 'left')
            ->join('penilaian_risiko pr',          'pr.id_penilaian = er.id_penilaian', 'left')
            ->join('kriteria_kemungkinan km',      'km.id_kriteria = pr.id_kemungkinan', 'left')
            ->join('kriteria_dampak kd',           'kd.id_kriteria = pr.id_dampak', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->join('rencana_penanganan_risiko rtp', 'rtp.id_penilaian_awal = er.id_evaluasi', 'left')
            ->join('kriteria_kemungkinan km_r',    'km_r.id_kriteria = rtp.id_kemungkinan_residu', 'left')
            ->join('kriteria_dampak kd_r',         'kd_r.id_kriteria = rtp.id_dampak_residu', 'left')
            ->where('er.opsi_tindakan', 'Mengurangi')
            ->orderBy('pb.kode_proses', 'ASC')
            ->orderBy('rtp.id_rtp',     'ASC');

        if ($idKonteks) {
            $builder->where('kpb.id_konteks', $idKonteks);
        }

        /* FILTER sudah/belum ada RTP */
        if ($filter === 'sudah') {
            $builder->where('rtp.id_rtp IS NOT NULL', null, false);
        } elseif ($filter === 'belum') {
            $builder->where('rtp.id_rtp IS NULL', null, false);
        }

        /* TOTAL DISTINCT EVALUASI */
        $qCount = $this->db->table('evaluasi_risiko er')
            ->select('COUNT(DISTINCT er.id_evaluasi) as total')
            ->join('identifikasi_risiko ir',    'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('rencana_penanganan_risiko rtp', 'rtp.id_penilaian_awal = er.id_evaluasi', 'left')
            ->where('er.opsi_tindakan', 'Mengurangi');

        if ($idKonteks) $qCount->where('kpb.id_konteks', $idKonteks);
        if ($filter === 'sudah') $qCount->where('rtp.id_rtp IS NOT NULL', null, false);
        if ($filter === 'belum') $qCount->where('rtp.id_rtp IS NULL',     null, false);

        $total = (int) ($qCount->get()->getRowArray()['total'] ?? 0);

        /* PAGINATED ROWS */
        $rows = $builder->limit($perPage, $offset)->get()->getResultArray();

        /* GROUP BY id_evaluasi */
        $grouped = [];
        foreach ($rows as $row) {
            $idEval = $row['id_evaluasi'];
            if (!isset($grouped[$idEval])) {
                $grouped[$idEval] = [
                    'id_evaluasi'       => $row['id_evaluasi'],
                    'id_identifikasi'   => $row['id_identifikasi'],
                    'pernyataan_risiko' => $row['pernyataan_risiko'],
                    'penyebab_risiko'   => $row['penyebab_risiko'],
                    'dampak_risiko'     => $row['dampak_risiko'],
                    'kode_proses'       => $row['kode_proses'],
                    'uraian_proses'     => $row['uraian_proses'],
                    'nama_satuan_kerja' => $row['nama_satuan_kerja'],
                    'id_penilaian'      => $row['id_penilaian'],
                    'nilai_risiko'      => $row['nilai_risiko'],
                    'warna_risiko'      => $row['warna_risiko'],
                    'level_kemungkinan' => $row['level_kemungkinan'],
                    'level_dampak'      => $row['level_dampak'],
                    'nama_selera'       => $row['nama_selera'],
                    'warna_selera'      => $row['warna_selera'],
                    'rtp_list'          => [],
                ];
            }

            if (!empty($row['id_rtp'])) {
                $levelP = (int) ($row['level_kemungkinan_residu'] ?? 0);
                $levelD = (int) ($row['level_dampak_residu']      ?? 0);
                $skorSR = ($levelP > 0 && $levelD > 0) ? $levelP * $levelD : null;

                $seleraResidu = null;
                if ($skorSR !== null) {
                    $seleraResidu = $this->db->table('selera_risiko')
                        ->where('nilai_min <=', $skorSR)
                        ->where('nilai_max >=', $skorSR)
                        ->get()->getRowArray();
                }

                $grouped[$idEval]['rtp_list'][] = [
                    'id_rtp'                   => $row['id_rtp'],
                    'uraian_rtp'               => $row['uraian_rtp'],
                    'target_output'            => $row['target_output'],
                    'target_waktu'             => $row['target_waktu'],
                    'id_kemungkinan_residu'    => $row['id_kemungkinan_residu'],
                    'id_dampak_residu'         => $row['id_dampak_residu'],
                    'level_kemungkinan_residu' => $levelP ?: null,
                    'level_dampak_residu'      => $levelD ?: null,
                    'nilai_sr_residu'          => $skorSR,
                    'nama_selera_residu'       => $seleraResidu['nama_level'] ?? null,
                    'warna_selera_residu'      => $seleraResidu['warna']      ?? null,
                ];
            }
        }

        /* NOMOR PRIORITAS */
        uasort($grouped, function ($a, $b) {
            return ($b['nilai_risiko'] ?? 0) <=> ($a['nilai_risiko'] ?? 0);
        });

        $counter = 1;
        foreach ($grouped as &$item) {
            $item['no_prioritas'] = $counter++;
        }
        unset($item);

        // Ganti ini — sort by no_prioritas ASC, bukan kode_proses
        uasort($grouped, function ($a, $b) {
            return ($a['no_prioritas'] ?? 0) <=> ($b['no_prioritas'] ?? 0);
        });

        $from = $total > 0 ? $offset + 1 : 0;
        $to   = min($offset + $perPage, $total);

        $totalPages = (int) ceil($total / max($perPage, 1));
        $pager = [
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'perPage'     => $perPage,
            'total'       => $total,
        ];

        /* SUMMARY & KRITERIA */
        $summary  = $this->getSummary($idKonteks);
        $kriteria = $this->getKriteriaList();

        return view('rencana_penanganan/index', [
            'grouped'             => $grouped,
            'listKonteks'         => $this->getListKonteks(),
            'activeKonteks'       => $activeKonteks,
            'total'               => $total,
            'from'                => $from,
            'to'                  => $to,
            'perPage'             => $perPage,
            'filter'              => $filter,
            'pager'               => $pager,
            'totalRisiko'         => $summary['totalRisiko'],
            'totalSudah'          => $summary['totalSudah'],
            'totalBelum'          => $summary['totalBelum'],
            'levelRisiko'         => $summary['levelRisiko'],
            'kriteriaKemungkinan' => $kriteria['kriteriaKemungkinan'],
            'kriteriaDampak'      => $kriteria['kriteriaDampak'],
        ]);
    }

    /* ======================================================
       SET / RESET ACTIVE KONTEKS
    ====================================================== */
    public function setActive()
    {
        $id = $this->request->getPost('id_konteks');
        if (!$id) return redirect()->back();
        session()->set('id_konteks_rtp', $id);
        return redirect()->to(site_url('rencana-penanganan'));
    }

    public function resetActive()
    {
        session()->remove('id_konteks_rtp');
        return redirect()->to(site_url('rencana-penanganan'));
    }

    /* ======================================================
       DETAIL RTP (AJAX — view/edit mode)
    ====================================================== */
    public function detail($id)
    {
        $data = $this->rtpModel->getRtpLengkap((int) $id);
        if (!$data) {
            return $this->response->setJSON(null);
        }

        // Ambil semua RTP milik evaluasi yang sama
        $rtpList = $this->db->table('rencana_penanganan_risiko rtp')
            ->select('rtp.id_rtp, rtp.uraian_rtp, rtp.target_output, rtp.target_waktu')
            ->where('rtp.id_penilaian_awal', $data['id_evaluasi'])
            ->orderBy('rtp.id_rtp', 'ASC')
            ->get()->getResultArray();

        $data['rtp_list'] = $rtpList;

        return $this->response->setJSON($data);
    }

    /* ======================================================
       DETAIL EVALUASI (AJAX — create mode)
    ====================================================== */
    public function detailEvaluasi($id)
    {
        $data = $this->db->table('evaluasi_risiko er')
            ->select('
                er.id_evaluasi,
                er.id_identifikasi,
                er.id_penilaian,
                er.opsi_tindakan,
                er.keterangan,
                ir.pernyataan_risiko,
                ir.penyebab_risiko,
                ir.dampak_risiko,
                pb.kode_proses,
                pb.uraian_proses,
                k.tahun,
                sk.nama_satuan_kerja,
                ss.uraian_sasaran as sasaran_strategis,
                g.nama as nama_pengelola,
                pr.nilai_risiko,
                pr.warna_risiko,
                km.level      as level_kemungkinan,
                km.nama_level as nama_kemungkinan,
                kd.level      as level_dampak,
                kd.nama_level as nama_dampak,
                sl.nama_level as nama_selera,
                sl.warna      as warna_selera
            ')
            ->join('identifikasi_risiko ir',    'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('proses_bisnis pb',          'pb.id_proses = kpb.id_proses')
            ->join('konteks k',                 'k.id_konteks = kpb.id_konteks')
            ->join('satuan_kerja sk',           'sk.id_satuan_kerja = k.id_satuan_kerja', 'left')
            ->join('sasaran_strategis ss',      'ss.id_sasaran_strategis = k.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko g',        'g.id = k.pengelola_risiko_id', 'left')
            ->join('penilaian_risiko pr',       'pr.id_penilaian = er.id_penilaian', 'left')
            ->join('kriteria_kemungkinan km',   'km.id_kriteria = pr.id_kemungkinan', 'left')
            ->join('kriteria_dampak kd',        'kd.id_kriteria = pr.id_dampak', 'left')
            ->join('selera_risiko sl',          'sl.id_selera = pr.id_selera', 'left')
            ->where('er.id_evaluasi', $id)
            ->get()->getRowArray();

        return $this->response->setJSON($data);
    }

    /* ======================================================
       STORE
    ====================================================== */
    public function store()
    {
        try {
            $idPenilaian = $this->request->getPost('id_penilaian_awal');
            $uraianList  = $this->request->getPost('uraian_rtp');
            $outputs     = $this->request->getPost('target_output');
            $waktus      = $this->request->getPost('target_waktu');
            $kemungkinan = $this->request->getPost('id_kemungkinan_residu') ?: null;
            $dampak      = $this->request->getPost('id_dampak_residu') ?: null;

            if (!is_array($uraianList)) $uraianList = [$uraianList];
            if (!is_array($outputs))    $outputs    = [$outputs];
            if (!is_array($waktus))     $waktus     = [$waktus];

            if (!$idPenilaian || empty($outputs)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => 'error',
                    'message' => 'Data RTP tidak lengkap',
                ]);
            }

            $this->db->transStart();

            foreach ($outputs as $i => $output) {
                if (!$output) continue;

                $targetWaktu = $waktus[$i] ?? null;
                if ($targetWaktu && strlen($targetWaktu) === 7) {
                    $targetWaktu = $targetWaktu . '-01';
                }

                $this->rtpModel->insert([
                    'id_penilaian_awal'     => $idPenilaian,
                    'uraian_rtp'            => $uraianList[$i] ?? null,
                    'target_output'         => $output,
                    'target_waktu'          => $targetWaktu,
                    'id_kemungkinan_residu' => $kemungkinan,
                    'id_dampak_residu'      => $dampak,
                ]);
            }

            $this->db->transComplete();

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'RTP berhasil disimpan',
                'csrf_token' => csrf_hash(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'RTP Store Error: ' . $e->getMessage());
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
            $db = $this->db;

            // Ambil id_evaluasi dari RTP yang diedit
            $existing = $db->table('rencana_penanganan_risiko')
                ->where('id_rtp', $id)
                ->get()->getRowArray();

            if (!$existing) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status'  => 'error',
                    'message' => 'Data RTP tidak ditemukan.',
                ]);
            }

            $idEvaluasi          = $existing['id_penilaian_awal'];
            $kemungkinanResidu   = $this->request->getPost('id_kemungkinan_residu') ?: null;
            $dampakResidu        = $this->request->getPost('id_dampak_residu') ?: null;

            $uraianList  = $this->request->getPost('uraian_rtp');
            $outputList  = $this->request->getPost('target_output');
            $waktuList   = $this->request->getPost('target_waktu');

            if (!is_array($uraianList)) $uraianList = [$uraianList];
            if (!is_array($outputList)) $outputList = [$outputList];
            if (!is_array($waktuList))  $waktuList  = [$waktuList];

            $db->transStart();

            // Hapus semua RTP lama milik evaluasi ini
            $db->table('rencana_penanganan_risiko')
                ->where('id_penilaian_awal', $idEvaluasi)
                ->delete();

            // Insert ulang semua RTP dari form
            foreach ($outputList as $i => $output) {
                if (!$output) continue;

                $targetWaktu = $waktuList[$i] ?? null;
                if ($targetWaktu && strlen($targetWaktu) === 7) {
                    $targetWaktu = $targetWaktu . '-01';
                }

                $db->table('rencana_penanganan_risiko')->insert([
                    'id_penilaian_awal'     => $idEvaluasi,
                    'uraian_rtp'            => $uraianList[$i] ?? null,
                    'target_output'         => $output,
                    'target_waktu'          => $targetWaktu,
                    'id_kemungkinan_residu' => $kemungkinanResidu,
                    'id_dampak_residu'      => $dampakResidu,
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaksi gagal.');
            }

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'RTP berhasil diperbarui',
                'csrf_token' => csrf_hash(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'RTP Update Error: ' . $e->getMessage());
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
            $this->rtpModel->delete($id);

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'RTP berhasil dihapus',
                'csrf_token' => csrf_hash(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'RTP Delete Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /* ======================================================
       GET KRITERIA (AJAX — endpoint publik jika diperlukan)
    ====================================================== */
    public function getKriteriaKemungkinan()
    {
        return $this->response->setJSON(
            $this->getKriteriaList()['kriteriaKemungkinan']
        );
    }

    public function getKriteriaDampak()
    {
        return $this->response->setJSON(
            $this->getKriteriaList()['kriteriaDampak']
        );
    }
}
