<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemantauanRisikoModel;
use App\Models\BuktiPemantauanModel;
use App\Models\KonteksModel;

class PemantauanRisikoController extends BaseController
{
    protected $pemantauanModel;
    protected $buktiModel;
    protected $db;

    public function __construct()
    {
        $this->pemantauanModel = new PemantauanRisikoModel();
        $this->buktiModel      = new BuktiPemantauanModel();
        $this->db              = \Config\Database::connect();
    }

    /* ======================================================
       ACTIVE KONTEKS
    ====================================================== */
    private function getActiveKonteks(): ?array
    {
        $id = session('id_konteks_pemantauan');
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
            session()->remove('id_konteks_pemantauan');
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
       SUMMARY STATS
    ====================================================== */
    private function getSummary(?int $idKonteks): array
    {
        $qTotal = $this->db->table('rencana_penanganan_risiko rtp')
            ->join('evaluasi_risiko er',        'er.id_evaluasi = rtp.id_penilaian_awal')
            ->join('identifikasi_risiko ir',    'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses');
        if ($idKonteks) $qTotal->where('kpb.id_konteks', $idKonteks);
        $totalRtp = $qTotal->countAllResults();

        $distribusi         = $this->pemantauanModel->getDistribusiStatus($idKonteks);
        $totalSudahDipantau = $totalRtp - ($distribusi['Belum Dilaksanakan'] ?? 0);

        return compact('totalRtp', 'totalSudahDipantau', 'distribusi');
    }

    /* ======================================================
       INDEX
    ====================================================== */
    public function index()
    {
        $activeKonteks = $this->getActiveKonteks();
        $idKonteks     = $activeKonteks ? (int) $activeKonteks['id_konteks'] : null;

        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $page    = (int) ($this->request->getGet('page')    ?? 1);
        $offset  = ($page - 1) * $perPage;
        $filter  = $this->request->getGet('filter');

        $builder = $this->db->table('rencana_penanganan_risiko rtp')
            ->select('
                ir.id_identifikasi,
                rtp.id_rtp,
                rtp.uraian_rtp,
                rtp.target_output,
                rtp.target_waktu,
                er.id_evaluasi,
                ir.pernyataan_risiko,
                ir.penyebab_risiko,
                ir.dampak_risiko,
                pb.kode_proses,
                pb.uraian_proses,
                sk.nama_satuan_kerja,
                pr.nilai_risiko,
                pr.warna_risiko,
                km.level      as level_kemungkinan,
                kd.level      as level_dampak,
                sl.nama_level as nama_selera,
                sl.warna      as warna_selera,
                pm.id_pemantauan,
                pm.realisasi_output,
                pm.realisasi_waktu,
                COALESCE(pm.status, \'Belum Dilaksanakan\') as status,
                pm.catatan,
                pm.updated_at as pemantauan_updated_at
            ')
            ->join('evaluasi_risiko er',        'er.id_evaluasi = rtp.id_penilaian_awal')
            ->join('identifikasi_risiko ir',    'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('proses_bisnis pb',          'pb.id_proses = kpb.id_proses')
            ->join('konteks k',                 'k.id_konteks = kpb.id_konteks')
            ->join('satuan_kerja sk',           'sk.id_satuan_kerja = k.id_satuan_kerja', 'left')
            ->join('penilaian_risiko pr',       'pr.id_penilaian = er.id_penilaian', 'left')
            ->join('kriteria_kemungkinan km',   'km.id_kriteria = pr.id_kemungkinan', 'left')
            ->join('kriteria_dampak kd',        'kd.id_kriteria = pr.id_dampak', 'left')
            ->join('selera_risiko sl',          'sl.id_selera = pr.id_selera', 'left')
            ->join('pemantauan_risiko pm',      'pm.id_rtp = rtp.id_rtp', 'left')
            ->orderBy('pb.kode_proses', 'ASC')
            ->orderBy('rtp.id_rtp', 'ASC');

        if ($idKonteks) {
            $builder->where('kpb.id_konteks', $idKonteks);
        }

        if ($filter && $filter !== 'semua') {
            if ($filter === 'Belum Dilaksanakan') {
                $builder->groupStart()
                    ->where('pm.id_pemantauan IS NULL', null, false)
                    ->orWhere('pm.status', 'Belum Dilaksanakan')
                    ->groupEnd();
            } else {
                $builder->where('pm.status', $filter);
            }
        }

        $qCount = $this->db->table('rencana_penanganan_risiko rtp')
            ->select('COUNT(rtp.id_rtp) as total')
            ->join('evaluasi_risiko er',        'er.id_evaluasi = rtp.id_penilaian_awal')
            ->join('identifikasi_risiko ir',    'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('pemantauan_risiko pm',      'pm.id_rtp = rtp.id_rtp', 'left');

        if ($idKonteks) $qCount->where('kpb.id_konteks', $idKonteks);

        if ($filter && $filter !== 'semua') {
            if ($filter === 'Belum Dilaksanakan') {
                $qCount->groupStart()
                    ->where('pm.id_pemantauan IS NULL', null, false)
                    ->orWhere('pm.status', 'Belum Dilaksanakan')
                    ->groupEnd();
            } else {
                $qCount->where('pm.status', $filter);
            }
        }

        $total = (int) ($qCount->get()->getRowArray()['total'] ?? 0);
        $rows  = $builder->limit($perPage, $offset)->get()->getResultArray();

        $grouped = [];
        foreach ($rows as $row) {
            $id = $row['id_identifikasi'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = ['nilai_risiko' => $row['nilai_risiko'] ?? 0, 'rows' => []];
            }
            $grouped[$id]['rows'][] = $row;
        }

        uasort($grouped, fn($a, $b) => ($b['nilai_risiko'] ?? 0) <=> ($a['nilai_risiko'] ?? 0));

        $sortedRows = [];
        foreach ($grouped as $g) {
            foreach ($g['rows'] as $r) $sortedRows[] = $r;
        }
        $rows = $sortedRows;

        foreach ($rows as &$row) {
            $row['jumlah_bukti'] = !empty($row['id_pemantauan'])
                ? $this->buktiModel->countByPemantauan((int) $row['id_pemantauan'])
                : 0;
        }
        unset($row);

        $from       = $total > 0 ? $offset + 1 : 0;
        $to         = min($offset + $perPage, $total);
        $totalPages = (int) ceil($total / max($perPage, 1));

        $summary = $this->getSummary($idKonteks);

        return view('pemantauan_risiko/index', [
            'data'               => $rows,
            'listKonteks'        => $this->getListKonteks(),
            'activeKonteks'      => $activeKonteks,
            'total'              => $total,
            'from'               => $from,
            'to'                 => $to,
            'perPage'            => $perPage,
            'filter'             => $filter,
            'pager'              => [
                'currentPage' => $page,
                'totalPages'  => $totalPages,
                'perPage'     => $perPage,
                'total'       => $total,
            ],
            'totalRtp'           => $summary['totalRtp'],
            'totalSudahDipantau' => $summary['totalSudahDipantau'],
            'distribusi'         => $summary['distribusi'],
            'statusList'         => ['Belum Dilaksanakan', 'Dalam Proses', 'Selesai', 'Terlambat'],
        ]);
    }

    /* ======================================================
       SET / RESET ACTIVE KONTEKS
    ====================================================== */
    public function setActive()
    {
        $id = $this->request->getPost('id_konteks');
        if (!$id) return redirect()->back();
        session()->set('id_konteks_pemantauan', $id);
        return redirect()->to(site_url('pemantauan-risiko'));
    }

    public function resetActive()
    {
        session()->remove('id_konteks_pemantauan');
        return redirect()->to(site_url('pemantauan-risiko'));
    }

    /* ======================================================
       DETAIL (AJAX)
       [FIX] Join sasaran_kinerja pakai id_konteks_proses,
             sama persis dengan EvaluasiRisikoController
    ====================================================== */
    public function detail($idRtp)
    {
        // Coba ambil via model jika pemantauan sudah ada
        $data = $this->pemantauanModel->getByRtp((int) $idRtp);

        if (!$data) {
            // Fallback: belum ada record pemantauan, ambil dari RTP saja
            $data = $this->db->table('rencana_penanganan_risiko rtp')
                ->select('
                    rtp.id_rtp,
                    rtp.uraian_rtp,
                    rtp.target_output,
                    rtp.target_waktu,
                    er.id_evaluasi,
                    ir.pernyataan_risiko,
                    ir.penyebab_risiko,
                    ir.dampak_risiko,
                    pb.kode_proses,
                    pb.uraian_proses,
                    sk.nama_satuan_kerja,
                    k.tahun,
                    ss.uraian_sasaran,
                    sk_kinerja.uraian_sasaran as uraian_sasaran_kinerja,
                    g.nama as nama_pengelola
                ')
                ->join('evaluasi_risiko er',        'er.id_evaluasi = rtp.id_penilaian_awal')
                ->join('identifikasi_risiko ir',    'ir.id_identifikasi = er.id_identifikasi')
                ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
                ->join('proses_bisnis pb',          'pb.id_proses = kpb.id_proses')
                ->join('konteks k',                 'k.id_konteks = kpb.id_konteks')
                ->join('satuan_kerja sk',           'sk.id_satuan_kerja = k.id_satuan_kerja',           'left')
                ->join('sasaran_strategis ss',      'ss.id_sasaran_strategis = k.id_sasaran_strategis', 'left')
                // [FIX] Sama dengan EvaluasiRisikoController: join via id_konteks_proses
                ->join('sasaran_kinerja sk_kinerja', 'sk_kinerja.id_konteks_proses = ir.id_konteks_proses', 'left')
                ->join('pengelola_risiko g',        'g.id = k.pengelola_risiko_id',                     'left')
                ->where('rtp.id_rtp', $idRtp)
                ->get()->getRowArray();

            if (!$data) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status'  => 'error',
                    'message' => 'Data RTP tidak ditemukan.',
                ]);
            }

            $data['id_pemantauan']         = null;
            $data['realisasi_output']      = null;
            $data['realisasi_waktu']       = null;
            $data['status']                = 'Belum Dilaksanakan';
            $data['catatan']               = null;
            $data['pemantauan_updated_at'] = null;
        }

        $data['bukti_list'] = !empty($data['id_pemantauan'])
            ? $this->buktiModel->getByPemantauan((int) $data['id_pemantauan'])
            : [];

        return $this->response->setJSON($data);
    }

    /* ======================================================
       STORE
    ====================================================== */
    public function store()
    {
        try {
            $idRtp           = $this->request->getPost('id_rtp');
            $realisasiOutput = $this->request->getPost('realisasi_output');
            $realisasiWaktuInput = $this->request->getPost('realisasi_waktu');

            $realisasiWaktu = null;
            if (!empty($realisasiWaktuInput)) {
                // convert YYYY-MM → YYYY-MM-01 00:00:00
                $realisasiWaktu = $realisasiWaktuInput . '-01 00:00:00';
            }
            $status          = $this->request->getPost('status') ?? 'Belum Dilaksanakan';
            $catatan         = $this->request->getPost('catatan') ?: null;

            if (empty($idRtp)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => 'error',
                    'message' => 'ID RTP tidak ditemukan.',
                ]);
            }

            $file = $this->request->getFile('bukti_file');
            if ($file && $file->isValid()) {
                $allowedMimes = ['image/jpeg', 'image/png', 'application/pdf'];
                $allowedExts  = ['jpg', 'jpeg', 'png', 'pdf'];

                if (
                    !in_array($file->getMimeType(), $allowedMimes)
                    || !in_array(strtolower($file->getExtension()), $allowedExts)
                ) {
                    return $this->response->setStatusCode(422)->setJSON([
                        'status'  => 'error',
                        'message' => 'File hanya boleh berupa JPG, PNG, atau PDF.',
                    ]);
                }
            }

            $this->db->transStart();

            $idPemantauan = $this->pemantauanModel->upsertByRtp((int) $idRtp, [
                'realisasi_output' => $realisasiOutput,
                'realisasi_waktu'  => $realisasiWaktu,
                'status'           => $status,
                'catatan'          => $catatan,
            ]);

            if ($file && $file->isValid()) {
                $this->buktiModel->hapusSemuaByPemantauan((int) $idPemantauan);
                $this->buktiModel->simpanFile($file, $idPemantauan);
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \RuntimeException('Transaksi gagal.');
            }

            $buktiList = $this->buktiModel->getByPemantauan((int) $idPemantauan);

            return $this->response->setJSON([
                'status'        => 'success',
                'message'       => 'Pemantauan berhasil disimpan.',
                'csrf_token'    => csrf_hash(),
                'bukti_list'    => $buktiList,
                'id_pemantauan' => $idPemantauan,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Pemantauan Store Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /* ======================================================
       DELETE BUKTI
    ====================================================== */
    public function deleteBukti($idBukti)
    {
        try {
            $berhasil = $this->buktiModel->hapusDenganFile((int) $idBukti);

            if (!$berhasil) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status'  => 'error',
                    'message' => 'File bukti tidak ditemukan.',
                ]);
            }

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'File bukti berhasil dihapus.',
                'csrf_token' => csrf_hash(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Pemantauan DeleteBukti Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /* ======================================================
       DELETE PEMANTAUAN
    ====================================================== */
    public function delete($idRtp)
    {
        try {
            $pemantauan = $this->pemantauanModel->where('id_rtp', $idRtp)->first();

            if (!$pemantauan) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status'  => 'error',
                    'message' => 'Data pemantauan tidak ditemukan.',
                ]);
            }

            $this->db->transStart();
            $this->buktiModel->hapusSemuaByPemantauan((int) $pemantauan['id_pemantauan']);
            $this->pemantauanModel->delete($pemantauan['id_pemantauan']);
            $this->db->transComplete();

            return $this->response->setJSON([
                'status'     => 'success',
                'message'    => 'Data pemantauan berhasil dihapus.',
                'csrf_token' => csrf_hash(),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Pemantauan Delete Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /* ======================================================
       VIEW BUKTI — full screen di tab baru
    ====================================================== */
    public function viewBukti($idBukti)
    {
        $bukti = $this->buktiModel->find((int) $idBukti);

        if (!$bukti) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan.');
        }

        $filePath = WRITEPATH . $bukti['path_file'];
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('File fisik tidak ditemukan.');
        }

        $mime        = mime_content_type($filePath);
        $ext         = strtolower(pathinfo($bukti['nama_file'], PATHINFO_EXTENSION));
        $fileData    = base64_encode(file_get_contents($filePath));
        $fileName    = $bukti['nama_file'];
        $downloadUrl = site_url('pemantauan-risiko/bukti/download/' . $idBukti);
        $isPdf       = ($mime === 'application/pdf' || $ext === 'pdf');
        $isImage     = in_array($ext, ['jpg', 'jpeg', 'png']);

        $html = '<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bukti Dukung — ' . htmlspecialchars($fileName) . '</title>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { background:#1a1a2e; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; height:100vh; display:flex; flex-direction:column; }
  .toolbar { background:#16213e; padding:10px 20px; display:flex; align-items:center; gap:12px; border-bottom:1px solid #0f3460; flex-shrink:0; }
  .toolbar-title { color:#e2e8f0; font-size:14px; font-weight:500; flex:1; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .btn-download { background:#3b82f6; color:#fff; border:none; padding:8px 18px; border-radius:6px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:background .2s; }
  .btn-download:hover { background:#2563eb; color:#fff; }
  .btn-close-tab { background:#475569; color:#fff; border:none; padding:8px 14px; border-radius:6px; font-size:13px; cursor:pointer; }
  .btn-close-tab:hover { background:#334155; }
  .viewer { flex:1; display:flex; align-items:center; justify-content:center; overflow:auto; padding:16px; }
  .viewer iframe { width:100%; height:100%; border:none; border-radius:4px; }
  .viewer img { max-width:100%; max-height:100%; object-fit:contain; border-radius:4px; box-shadow:0 4px 24px rgba(0,0,0,.5); }
  .unsupported { color:#94a3b8; text-align:center; }
</style>
</head>
<body>
  <div class="toolbar">
    <span class="toolbar-title">📎 ' . htmlspecialchars($fileName) . '</span>
    <a href="' . $downloadUrl . '" class="btn-download" download>⬇ Unduh File</a>
    <button class="btn-close-tab" onclick="window.close()">✕ Tutup</button>
  </div>
  <div class="viewer">';

        if ($isPdf) {
            $html .= '<iframe src="data:application/pdf;base64,' . $fileData . '" type="application/pdf"></iframe>';
        } elseif ($isImage) {
            $html .= '<img src="data:' . $mime . ';base64,' . $fileData . '" alt="' . htmlspecialchars($fileName) . '">';
        } else {
            $html .= '<div class="unsupported"><p>Format tidak dapat ditampilkan.</p><a href="' . $downloadUrl . '" class="btn-download" style="margin-top:16px">⬇ Unduh File</a></div>';
        }

        $html .= '</div></body></html>';

        return $this->response
            ->setHeader('Content-Type', 'text/html; charset=utf-8')
            ->setBody($html);
    }

    /* ======================================================
       DOWNLOAD BUKTI
    ====================================================== */
    public function downloadBukti($idBukti)
    {
        $bukti = $this->buktiModel->find((int) $idBukti);

        if (!$bukti) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan.');
        }

        $filePath = WRITEPATH . $bukti['path_file'];
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('File fisik tidak ditemukan.');
        }

        return $this->response->download($filePath, null)->setFileName($bukti['nama_file']);
    }
}
