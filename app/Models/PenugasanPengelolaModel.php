<?php

namespace App\Models;

use CodeIgniter\Model;

class PenugasanPengelolaModel extends Model
{
    protected $table            = 'penugasan_pengelola';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'pengelola_id',
        'satuan_kerja_id',
        'tahun',
        'is_ketua_tim',
    ];

    // -------------------------------------------------------
    // Ambil pengelola (ketua tim) berdasarkan satuan kerja & tahun
    // -------------------------------------------------------
    public function getKetuaTim(int $satuan_kerja_id, int $tahun): ?array
    {
        return $this->db->table('penugasan_pengelola pp')
            ->select('pr.*, pp.tahun, pp.is_ketua_tim')
            ->join('pengelola_risiko pr', 'pr.id = pp.pengelola_id')
            ->where('pp.satuan_kerja_id', $satuan_kerja_id)
            ->where('pp.tahun', $tahun)
            ->where('pp.is_ketua_tim', true)
            ->get()
            ->getRowArray();
    }

    // -------------------------------------------------------
    // Ambil semua pengelola berdasarkan satuan kerja & tahun
    // -------------------------------------------------------
    public function getPengelolaBySatuanKerja(int $satuan_kerja_id, int $tahun): array
    {
        return $this->db->table('penugasan_pengelola pp')
            ->select('pr.*, pp.tahun, pp.is_ketua_tim')
            ->join('pengelola_risiko pr', 'pr.id = pp.pengelola_id')
            ->where('pp.satuan_kerja_id', $satuan_kerja_id)
            ->where('pp.tahun', $tahun)
            ->get()
            ->getResultArray();
    }

    // -------------------------------------------------------
    // Fallback: kalau tahun tidak ada, ambil tahun terdekat
    // -------------------------------------------------------
    public function getKetuaTimWithFallback(int $satuan_kerja_id, int $tahun): ?array
    {
        // Coba cari tahun yang diminta dulu
        $result = $this->getKetuaTim($satuan_kerja_id, $tahun);

        if ($result) {
            $result['is_fallback'] = false;
            return $result;
        }

        // Kalau tidak ada, ambil tahun terdekat yang tersedia
        $fallback = $this->db->table('penugasan_pengelola pp')
            ->select('pr.*, pp.tahun, pp.is_ketua_tim')
            ->join('pengelola_risiko pr', 'pr.id = pp.pengelola_id')
            ->where('pp.satuan_kerja_id', $satuan_kerja_id)
            ->where('pp.is_ketua_tim', true)
            ->orderBy('ABS(pp.tahun - ' . (int)$tahun . ')', 'ASC')
            ->get()
            ->getRowArray();

        if ($fallback) {
            $fallback['is_fallback'] = true;
        }

        return $fallback;
    }

    // -------------------------------------------------------
    // Cek apakah sudah ada penugasan untuk satuan kerja & tahun
    // -------------------------------------------------------
    public function sudahAdaPenugasan(int $satuan_kerja_id, int $tahun): bool
    {
        return $this->where('satuan_kerja_id', $satuan_kerja_id)
            ->where('tahun', $tahun)
            ->countAllResults() > 0;
    }
}
