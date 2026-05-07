<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemantauanRisikoModel;

class PelaporanRisikoController extends BaseController
{
    protected $db;
    protected $pemantauanModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->pemantauanModel = new PemantauanRisikoModel();
    }

    private function getListKonteks()
    {
        return $this->db->table('konteks k')
            ->select('k.id_konteks,k.tahun,k.id_tim,k.id_kegiatan,k.pengelola_risiko_id,g.nama as nama_pengelola,sk.nama_tim,kegiatan.nama_kegiatan')
            ->join('tim_kerja sk', 'sk.id_tim=k.id_tim', 'left')
            ->join('kegiatan', 'kegiatan.id_kegiatan=k.id_kegiatan', 'left')
            ->join('pengelola_risiko g', 'g.id=k.pengelola_risiko_id', 'left')
            ->orderBy('k.created_at', 'DESC')
            ->get()->getResultArray();
    }

    private function getPeriode()
    {
        $periode = session('pl_periode');
        if (!$periode) {
            $periode = ['bulan' => date('m'), 'tahun' => date('Y')];
        }
        return $periode;
    }

    private function getDateRange($bulan, $tahun, $type = 'bulanan')
    {
        $startDate = date('Y-m-01', strtotime("$tahun-$bulan-01"));
        if ($type === '3bulan') {
            $endDate = date('Y-m-t', strtotime("+2 months", strtotime($startDate)));
        } else {
            $endDate = date('Y-m-t', strtotime($startDate));
        }
        return [$startDate, $endDate];
    }

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

    public function index()
    {
        $userRole  = session('user_role');
        $idKonteks = session('id_konteks_pl');
        $periode   = $this->getPeriode();
        $bulan     = $periode['bulan'];
        $tahun     = $periode['tahun'];
        $type      = $this->request->getGet('tipe_periode') ?? 'bulanan';
        $idKegiatan = $this->request->getGet('id_kegiatan');

        $builder = $this->db->table('rencana_penanganan_risiko rtp')
            ->select('
                rtp.id_rtp,
                rtp.uraian_rtp,
                rtp.target_output,
                rtp.target_waktu,
                ir.pernyataan_risiko,
                sk.nama_tim,
                kegiatan.id_kegiatan,
                kegiatan.nama_kegiatan,
                pm.realisasi_output,
                pm.realisasi_waktu,
                COALESCE(pm.status, \'Belum Dilaksanakan\') as status
            ')
            ->join('evaluasi_risiko er', 'er.id_evaluasi = rtp.id_penilaian_awal')
            ->join('identifikasi_risiko ir', 'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('tim_kerja sk', 'sk.id_tim = k.id_tim', 'left')
            ->join('kegiatan', 'kegiatan.id_kegiatan = k.id_kegiatan', 'left')
            ->join('pemantauan_risiko pm', 'pm.id_rtp = rtp.id_rtp', 'left');

        $ketuaInfo = null;

        if ($userRole === 'operator') {

            $idTim = session('id_tim');

            if ($idTim) {

                // filter data operator
                $builder->where('k.id_tim', $idTim);

                // ambil info tim + ketua
                $ketuaInfo = $this->db->table('tim_kerja sk')
                    ->select('sk.nama_tim, g.nama')
                    ->join(
                        'penugasan_pengelola p',
                        'p.tim_kerja_id = sk.id_tim',
                        'left'
                    )
                    ->join('pengelola_risiko g', 'g.id = p.pengelola_id', 'left')
                    ->where('sk.id_tim', $idTim)
                    ->where('p.is_ketua_tim', true)
                    ->get()
                    ->getRowArray();
            }
        } elseif ($userRole === 'ketua') {

            $pengelola_id = session('pengelola_id');

            $penugasan = $this->db->table('penugasan_pengelola')
                ->where('pengelola_id', $pengelola_id)
                ->get()
                ->getRow();

            if ($penugasan) {

                $idTim = $penugasan->tim_kerja_id;

                // filter data ketua
                $builder->where('k.id_tim', $idTim);

                // info dirinya sendiri
                $ketuaInfo = $this->db->table('tim_kerja sk')
                    ->select('sk.nama_tim, g.nama')
                    ->join(
                        'penugasan_pengelola p',
                        'p.tim_kerja_id = sk.id_tim',
                        'left'
                    )
                    ->join('pengelola_risiko g', 'g.id = p.pengelola_id', 'left')
                    ->where('sk.id_tim', $idTim)
                    ->where('p.is_ketua_tim', true)
                    ->get()
                    ->getRowArray();
            }
        } else {
            if ($idKonteks) {
                $builder->where('kpb.id_konteks', $idKonteks);
            }
        }
        
        if (!empty($idKegiatan)) {
            $builder->where('k.id_kegiatan', $idKegiatan);
        }

        if ($type === 'range') {
            $start = $this->request->getGet('start_periode');
            $end   = $this->request->getGet('end_periode');

            if ($start && $end) {
                $startDate = date('Y-m-01', strtotime($start));
                $endDate   = date('Y-m-t', strtotime($end));
            } else {
                [$startDate, $endDate] = $this->getDateRange($bulan, $tahun, 'bulanan');
            }
        } else {
            [$startDate, $endDate] = $this->getDateRange($bulan, $tahun, $type);
        }

        $builder->groupStart()
            ->where('rtp.target_waktu <=', $endDate)
            ->groupStart()
            ->groupStart()
            ->where('pm.status IS NULL', null, false)
            ->orWhereIn('pm.status', ['Dalam Proses', 'Belum Dilaksanakan', 'Terlambat'])
            ->groupEnd()
            ->orGroupStart()
            ->where('pm.realisasi_waktu >=', $startDate)
            ->where('pm.realisasi_waktu <=', $endDate)
            ->groupEnd()
            ->orGroupStart()
            ->where('pm.updated_at >=', $startDate)
            ->where('pm.updated_at <=', $endDate)
            ->groupEnd()
            ->groupEnd()
            ->groupEnd();

        $builder->orderBy('kegiatan.nama_kegiatan', 'ASC');
        $builder->orderBy('rtp.id_rtp', 'ASC');

        $allData = $builder->get()->getResultArray();

        $page    = (int)($this->request->getGet('page') ?? 1);
        $perPage = (int)($this->request->getGet('perPage') ?? 10);

        $total  = count($allData);
        $offset = ($page - 1) * $perPage;
        $data   = array_slice($allData, $offset, $perPage);

        $pager = [
            'currentPage' => $page,
            'totalPages' => (int)ceil($total / $perPage),
        ];

        $from = $total > 0 ? $offset + 1 : 0;
        $to   = min($offset + $perPage, $total);

        $summary = [
            'total' => $total,
            'selesai' => 0,
            'dalam_proses' => 0,
            'belum' => 0,
            'terlambat' => 0,
        ];

        foreach ($allData as $row) {
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

        $listKegiatan = $this->db->table('kegiatan')
            ->select('id_kegiatan, nama_kegiatan, id_tim')
            ->orderBy('nama_kegiatan', 'ASC')
            ->get()
            ->getResultArray();

        return view('pelaporan_risiko/index', [
            'data' => $data,
            'summary' => $summary,
            'listKonteks' => $this->getListKonteks(),
            'periode' => $periode,
            'userRole' => $userRole,
            'pager' => $pager,
            'perPage' => $perPage,
            'total' => $total,
            'from' => $from,
            'to' => $to,
            'ketuaInfo' => $ketuaInfo,
            'tipe_periode' => $type,
            'activeKonteks' => [
                'id_tim' => $this->request->getGet('id_tim'),
                'pengelola_risiko_id' => $this->request->getGet('pengelola_risiko_id'),
            ],
            'listKegiatan' => $listKegiatan,
            'selectedKegiatan' => $idKegiatan,
        ]);
    }

    public function detail($id)
    {
        $data = $this->db->table('rencana_penanganan_risiko rtp')
            ->select('rtp.id_rtp,rtp.uraian_rtp,rtp.target_output,rtp.target_waktu,ir.pernyataan_risiko,ir.penyebab_risiko,ir.dampak_risiko,sk.nama_tim,kegiatan.nama_kegiatan,g.nama as nama_pengelola,k.tahun,ss.uraian_sasaran as sasaran_strategis,pb.kode_proses,pb.uraian_proses,sk_kinerja.uraian_sasaran as sasaran_kinerja,pr.nilai_risiko,pr.warna_risiko,pr.tindakan as tindakan_selera,pr.efektivitas,pr.uraian_pengendalian,sl.nama_level as nama_selera,km.level as level_kemungkinan,kd.level as level_dampak,pm.realisasi_output,pm.realisasi_waktu,COALESCE(pm.status, \'Belum Dilaksanakan\') as status')
            ->join('evaluasi_risiko er', 'er.id_evaluasi = rtp.id_penilaian_awal')
            ->join('identifikasi_risiko ir', 'ir.id_identifikasi = er.id_identifikasi')
            ->join('penilaian_risiko pr', 'pr.id_penilaian = er.id_penilaian', 'left')
            ->join('kriteria_kemungkinan km', 'km.id_kriteria = pr.id_kemungkinan', 'left')
            ->join('kriteria_dampak kd', 'kd.id_kriteria = pr.id_dampak', 'left')
            ->join('selera_risiko sl', 'sl.id_selera = pr.id_selera', 'left')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('tim_kerja sk', 'sk.id_tim = k.id_tim', 'left')
            ->join('kegiatan', 'kegiatan.id_kegiatan = k.id_kegiatan', 'left')
            ->join('sasaran_strategis ss', 'ss.id_sasaran_strategis = k.id_sasaran_strategis', 'left')
            ->join('pengelola_risiko g', 'g.id = k.pengelola_risiko_id', 'left')
            ->join('sasaran_kinerja sk_kinerja', 'sk_kinerja.id_konteks_proses = ir.id_konteks_proses', 'left')
            ->join('pemantauan_risiko pm', 'pm.id_rtp = rtp.id_rtp', 'left')
            ->where('rtp.id_rtp', $id)
            ->get()->getRowArray();

        return $this->response->setJSON($data);
    }

    public function approve($id)
    {
        if (session('user_role') !== 'ketua') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Akses ditolak']);
        }

        $this->pemantauanModel->where('id_rtp', $id)->set([
            'status' => 'Selesai',
            'updated_at' => date('Y-m-d H:i:s')
        ])->update();

        return $this->response->setJSON(['success' => true]);
    }

    public function reject($id)
    {
        if (session('user_role') !== 'ketua') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Akses ditolak']);
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
        $periode = session('pl_periode') ?? ['bulan' => date('m'), 'tahun' => date('Y')];
        $bulan = $periode['bulan'];
        $tahun = $periode['tahun'];

        $bulanNama = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $data = $this->db->table('rencana_penanganan_risiko rtp')
            ->select('rtp.uraian_rtp,ir.pernyataan_risiko,pm.realisasi_output,COALESCE(pm.status, \'Belum Dilaksanakan\') as status,sk.nama_tim')
            ->join('evaluasi_risiko er', 'er.id_evaluasi = rtp.id_penilaian_awal')
            ->join('identifikasi_risiko ir', 'ir.id_identifikasi = er.id_identifikasi')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = ir.id_konteks_proses')
            ->join('konteks k', 'k.id_konteks = kpb.id_konteks')
            ->join('tim_kerja sk', 'sk.id_tim = k.id_tim', 'left')
            ->join('pemantauan_risiko pm', 'pm.id_rtp = rtp.id_rtp', 'left')
            ->orderBy('rtp.id_rtp', 'ASC')
            ->get()->getResultArray();

        $ketua = $this->db->table('pengelola_risiko g')
            ->select('g.nama')
            ->join('penugasan_pengelola p', 'p.pengelola_id = g.id', 'left')
            ->where('p.is_ketua_tim', true)
            ->get()->getRowArray();

        return view('pelaporan_risiko/print', [
            'data' => $data,
            'bulan' => $bulanNama[$bulan] ?? $bulan,
            'tahun' => $tahun,
            'satker' => $data[0]['nama_tim'] ?? '-',
            'nama_ketua' => $ketua['nama'] ?? '(................................)'
        ]);
    }
}
