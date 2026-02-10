<?php

namespace App\Models;

use CodeIgniter\Model;

class ProsesBisnisModel extends Model
{
    protected $table            = 'proses_bisnis';
    protected $primaryKey       = 'id_proses';

    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields    = [
        'id_konteks',
        'kode_proses',
        'jenis_proses',
        'uraian_proses',
    ];

    /**
     * Ambil proses bisnis berdasarkan konteks
     */
    public function getByKonteks($id_konteks)
    {
        return $this
            ->where('id_konteks', $id_konteks)
            ->orderBy('kode_proses', 'ASC')
            ->findAll();
    }

    /**
     * Ambil proses bisnis + konteks (untuk list/detail)
     */
    public function getWithKonteks($id_proses)
    {
        return $this
            ->select('proses_bisnis.*, konteks.satuan_kerja, konteks.kegiatan, konteks.tahun')
            ->join('konteks', 'konteks.id_konteks = proses_bisnis.id_konteks', 'left')
            ->where('id_proses', $id_proses)
            ->first();
    }
}
