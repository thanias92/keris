<?php

namespace App\Models;

use CodeIgniter\Model;

class SasaranKinerjaModel extends Model
{
    protected $table            = 'sasaran_kinerja';
    protected $primaryKey       = 'id_sasaran';

    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields    = [
        'id_proses',
        'kode_sasaran',
        'uraian_sasaran',
    ];

    /**
     * Ambil sasaran kinerja berdasarkan konteks
     */
    public function getByKonteks($idKonteks)
    {
        return $this
            ->select('sasaran_kinerja.*, proses_bisnis.kode_proses, proses_bisnis.uraian_proses')
            ->join('proses_bisnis', 'proses_bisnis.id_proses = sasaran_kinerja.id_proses')
            ->where('proses_bisnis.id_konteks', $idKonteks)
            ->orderBy('kode_proses', 'ASC')
            ->findAll();
    }
}
