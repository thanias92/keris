<?php

namespace App\Models;

use CodeIgniter\Model;

class KonteksModel extends Model
{
    protected $table            = 'konteks';
    protected $primaryKey       = 'id_konteks';

    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'id_satuan_kerja',
        'pemilik_risiko_id',
        'pengelola_risiko_id',
        'id_kegiatan',
        'tahun',
        'id_sasaran_strategis',
    ];

    /**
     * Ambil semua konteks (untuk card filter)
     */
    public function getAll()
    {
        return $this
            ->select('
            konteks.*,
            satuan_kerja.nama_satuan_kerja,
            p.nama as nama_pemilik,
            g.nama as nama_pengelola
        ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja', 'left')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
            ->orderBy('tahun', 'DESC')
            ->orderBy('satuan_kerja.nama_satuan_kerja', 'ASC')
            ->findAll();
    }

    /**
     * Ambil 1 konteks lengkap (future-ready)
     */
    public function getById($id_konteks)
    {
        return $this->where('id_konteks', $id_konteks)->first();
    }
}
