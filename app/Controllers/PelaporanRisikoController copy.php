<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemantauanRisikoModel;

class PelaporanRisikoController extends BaseController
{
    protected $db;
    protected $pemantauanModel;

    // fungsinya untuk inisialisasi dependency
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->pemantauanModel = new PemantauanRisikoModel();
    }

    // fungsinya untuk mengambil daftar konteks
    private function getListKonteks()
    {
        return $this->db->table('konteks k')
            ->select('k.id_konteks,k.tahun,k.id_satuan_kerja,k.id_kegiatan,k.pengelola_risiko_id,g.nama as nama_pengelola,sk.nama_satuan_kerja,kegiatan.nama_kegiatan')
            ->join('satuan_kerja sk', 'sk.id_satuan_kerja=k.id_satuan_kerja', 'left')
            ->join('kegiatan', 'kegiatan.id_kegiatan=k.id_kegiatan', 'left')
            ->join('pengelola_risiko g', 'g.id=k.pengelola_risiko_id', 'left')
            ->orderBy('k.created_at', 'DESC')
            ->get()->getResultArray();
    }

    // fungsinya untuk mengambil periode aktif
    private function getPeriode()
    {
        $periode = session('pl_periode');
        if (!$periode) {
            $periode = ['bulan' => date('m'), 'tahun' => date('Y')];
        }
        return $periode;
    }

    // fungsinya untuk set konteks + periode
    public function setActive()
    {
        $id = $this->request->getPost('id_konteks');
        $periode = $this->request->getPost('periode');

        if ($id) {
            session()->set('id_konteks_pl', $id);
        }

        if ($periode) {
            [$tahun, $bulan] = explode('-', $periode);
            session()->set('pl_periode', [
                'bulan' => $bulan,
                'tahun' => $tahun
            ]);
        }

        return redirect()->to('/pelaporan-risiko');
    }

    // fungsinya untuk menampilkan halaman pelaporan risiko
    public function index()
    {
        $userRole  = session('user_role');
        $idKonteks = session('id_konteks_pl');
        $periode   = $this->getPeriode();
        $bulan     = $periode['bulan'];
        $tahun     = $periode['tahun'];

        $builder = $this->db->table('rencana_penanganan_risiko rtp')
            ->select('
            rtp.id_rtp,
            rtp.uraian_rtp,
            rtp.target_output,
            rtp.target_waktu,
            ir.pernyataan_risiko,
            sk.nama_satuan_kerja,
            pm.realisasi_output,
            pm.realisasi_waktu,
            COALESCE(pm.status, \'Belum Dilaksanakan\') as status
        ')
            ->join('evaluasi_risiko er',         'er.id_evaluasi = rtp.id_penilaian_awal')
            ->join('identifikasi_risiko ir',     'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb',  'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k',                  'k.id_konteks = kpb.id_konteks')
            ->join('satuan_kerja sk',            'sk.id_satuan_kerja = k.id_satuan_kerja', 'left')
            ->join('pemantauan_risiko pm',       'pm.id_rtp = rtp.id_rtp', 'left');

        // Filter konteks
        if ($userRole === 'admin' || $userRole === 'operator') {
            if ($idKonteks) {
                $builder->where('kpb.id_konteks', $idKonteks);
            }
        }

        if ($userRole === 'ketua') {
            $pengelola_id = session('pengelola_id');
            $penugasan = $this->db->table('penugasan_pengelola')
                ->where('pengelola_id', $pengelola_id)
                ->get()->getRow();

            if ($penugasan) {
                $builder->where('k.id_satuan_kerja', $penugasan->satuan_kerja_id);
            }
        }

        /*
     * Filter periode — tampilkan RTP yang RELEVAN dengan bulan/tahun dipilih:
     * 1. Target waktu <= akhir bulan yang dipilih (sudah jatuh tempo atau sedang berjalan)
     * 2. Belum selesai ATAU selesai/ditolak di bulan yang dipilih
     * Dengan kata lain: semua RTP yang target waktunya <= periode dipilih
     * dan belum selesai, ATAU yang realisasinya di bulan tersebut
     */
        $periodeStr = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);

        $builder->groupStart()
            // Target waktu sudah lewat atau sama dengan bulan dipilih
            ->where("TO_CHAR(rtp.target_waktu, 'YYYY-MM') <=", $periodeStr)
            ->groupStart()
            // Belum selesai / masih aktif
            ->groupStart()
            ->where('pm.status IS NULL', null, false)
            ->orWhereIn('pm.status', ['Dalam Proses', 'Belum Dilaksanakan', 'Terlambat'])
            ->groupEnd()
            // ATAU realisasi di bulan yang dipilih
            ->orWhere("TO_CHAR(pm.realisasi_waktu, 'YYYY-MM')", $periodeStr)
            // ATAU selesai/ditolak di bulan yang dipilih
            ->orWhere("TO_CHAR(pm.updated_at, 'YYYY-MM')", $periodeStr)
            ->groupEnd()
            ->groupEnd();

        $builder->orderBy('rtp.id_rtp', 'ASC');

        $data = $builder->get()->getResultArray();

        $page    = (int)($this->request->getGet('page')    ?? 1);
        $perPage = (int)($this->request->getGet('perPage') ?? 10);

        $total  = count($data);
        $offset = ($page - 1) * $perPage;
        $data   = array_slice($data, $offset, $perPage);

        $pager = [
            'currentPage' => $page,
            'totalPages'  => (int)ceil($total / $perPage),
        ];

        $from = $total > 0 ? $offset + 1 : 0;
        $to   = min($offset + $perPage, $total);

        // Summary dihitung dari SEMUA data (sebelum slice)
        $allData = $builder->get()->getResultArray(); // ambil ulang untuk summary

        $summary = [
            'total'       => $total,
            'selesai'     => 0,
            'dalam_proses' => 0,
            'belum'       => 0,
            'terlambat'   => 0,
        ];

        foreach ($data as $row) {
            switch ($row['status']) {
                case 'Selesai':
                    $summary['selesai']++;
                    break;
                case 'Dalam Proses':
                    $summary['dalam_proses']++;
                    break;
                case 'Terlambat':
                    $summary['terlambat']++;
                    break;
                default:
                    $summary['belum']++;
                    break;
            }
        }

        $ketuaInfo = null;
        if ($userRole === 'ketua') {
            $pengelola_id = session('pengelola_id');
            $ketuaInfo = $this->db->table('pengelola_risiko g')
                ->select('g.nama, sk.nama_satuan_kerja')
                ->join('penugasan_pengelola p', 'p.pengelola_id = g.id', 'left')
                ->join('satuan_kerja sk',       'sk.id_satuan_kerja = p.satuan_kerja_id', 'left')
                ->where('g.id', $pengelola_id)
                ->get()->getRowArray();
        }

        return view('pelaporan_risiko/index', [
            'data'        => $data,
            'summary'     => $summary,
            'listKonteks' => $this->getListKonteks(),
            'periode'     => $periode,
            'userRole'    => $userRole,
            'pager'       => $pager,
            'perPage'     => $perPage,
            'total'       => $total,
            'from'        => $from,
            'to'          => $to,
            'ketuaInfo'   => $ketuaInfo,
        ]);
    }

    // fungsinya untuk mengambil detail pelaporan
    public function detail($id)
    {
        $data = $this->db->table('rencana_penanganan_risiko rtp')
            ->select('
            rtp.id_rtp,
            rtp.uraian_rtp,
            rtp.target_output,
            rtp.target_waktu,

            ir.pernyataan_risiko,
            ir.penyebab_risiko,
            ir.dampak_risiko,

            sk.nama_satuan_kerja,
            g.nama as nama_pengelola,
            k.tahun,
            ss.uraian_sasaran as sasaran_strategis,
            pb.kode_proses,
            pb.uraian_proses,
            sk_kinerja.uraian_sasaran as sasaran_kinerja,

            pr.nilai_risiko,
            pr.warna_risiko,
            pr.tindakan as tindakan_selera,
            pr.efektivitas,
            pr.uraian_pengendalian,
            sl.nama_level as nama_selera,
            km.level as level_kemungkinan,
            kd.level as level_dampak,

            pm.realisasi_output,
            pm.realisasi_waktu,
            COALESCE(pm.status, \'Belum Dilaksanakan\') as status
        ')
            ->join('evaluasi_risiko er', 'er.id_evaluasi = rtp.id_penilaian_awal')
            ->join('identifikasi_risiko ir', 'ir.id_identifikasi = er.id_identifikasi')
            ->join('penilaian_risiko pr', 'pr.id_penilaian = er.id_penilaian', 'left')
            ->join('kriteria_kemungkinan km', 'km.id_kriteria = pr.id_kemungkinan', 'left')
            ->join('kriteria_dampak kd', 'kd.id_kriteria = pr.id_dampak', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('satuan_kerja sk', 'sk.id_satuan_kerja = k.id_satuan_kerja', 'left')
            ->join('sasaran_strategis ss', 'ss.id_sasaran_strategis = k.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko g', 'g.id = k.pengelola_risiko_id', 'left')
            ->join('sasaran_kinerja sk_kinerja', 'sk_kinerja.id_konteks_proses = ir.id_konteks_proses', 'left')
            ->join('pemantauan_risiko pm', 'pm.id_rtp = rtp.id_rtp', 'left')
            ->where('rtp.id_rtp', $id)
            ->get()
            ->getRowArray();

        return $this->response->setJSON($data);
    }

    // fungsinya untuk approve RTP (hanya ketua)
    public function approve($id)
    {
        if (session('user_role') !== 'ketua') {
            return $this->response->setStatusCode(403)->setJSON([
                'error' => 'Akses ditolak'
            ]);
        }

        $this->pemantauanModel->where('id_rtp', $id)->set([
            'status' => 'Selesai',
            'updated_at' => date('Y-m-d H:i:s')
        ])->update();

        return $this->response->setJSON(['success' => true]);
    }

    // fungsinya untuk reject RTP (hanya ketua)
    public function reject($id)
    {
        if (session('user_role') !== 'ketua') {
            return $this->response->setStatusCode(403)->setJSON([
                'error' => 'Akses ditolak'
            ]);
        }

        $payload = $this->request->getJSON(true);

        $this->pemantauanModel->where('id_rtp', $id)->set([
            'status' => 'Ditolak',
            'alasan_penolakan' => $payload['alasan'] ?? null,
            'updated_at' => date('Y-m-d H:i:s')
        ])->update();

        return $this->response->setJSON(['success' => true]);
    }

    public function print()
    {
        $data = $this->db->table('rencana_penanganan_risiko rtp')
            ->select('rtp.uraian_rtp, ir.pernyataan_risiko, pm.realisasi_output, pm.status')
            ->join('evaluasi_risiko er', 'er.id_evaluasi = rtp.id_penilaian_awal')
            ->join('identifikasi_risiko ir', 'ir.id_identifikasi = er.id_identifikasi')
            ->join('pemantauan_risiko pm', 'pm.id_rtp = rtp.id_rtp', 'left')
            ->get()->getResultArray();

        return view('pelaporan_risiko/print', [
            'data' => $data
        ]);
    }
    
}
