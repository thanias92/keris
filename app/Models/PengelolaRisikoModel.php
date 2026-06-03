<?php

namespace App\Models;

use CodeIgniter\Model;

class PengelolaRisikoModel extends Model
{
    protected $table = 'pengelola_risiko';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'nama',
        'nip',
        'jabatan',
        'wilayah_id',
        'is_pemilik',
        'aktif',
    ];

    // Ambil pemilik risiko berdasarkan wilayah
    public function getPemilikByWilayah($wilayah_id)
    {
        return $this
            ->where('wilayah_id', $wilayah_id)
            ->where('is_pemilik', true)
            ->where('aktif', true)
            ->first();
    }

    // Ambil semua pengelola berdasarkan tim kerja & tahun
    // → delegasi ke PenugasanPengelolaModel
    public function getPengelolaByTimKerja($tim_kerja_id, $tahun = null)
    {
        $tahun = $tahun ?? (int) date('Y');

        return $this->db->table('penugasan_pengelola pp')
            ->select('pr.*')
            ->join('pengelola_risiko pr', 'pr.id = pp.pengelola_id')
            ->where('pp.tim_kerja_id', $tim_kerja_id)
            ->where('pp.tahun', $tahun)
            ->where('pr.aktif', true)
            ->get()
            ->getResultArray();
    }
}
