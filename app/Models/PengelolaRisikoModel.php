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
        'is_pengelola',
        'aktif',
        'id_satuan_kerja',
    ];

    public function getPemilikByWilayah($wilayah_id)
    {
        return $this
            ->where('wilayah_id', $wilayah_id)
            ->where('is_pemilik', true)
            ->where('aktif', true)
            ->first();
    }

    public function getPengelolaByWilayah($wilayah_id)
    {
        return $this
            ->where('wilayah_id', $wilayah_id)
            ->where('is_pengelola', true)
            ->where('aktif', true)
            ->findAll();
    }
    public function getPengelolaBySatuanKerja($satuan_id)
    {
        return $this
            ->where('id_satuan_kerja', $satuan_id)
            ->where('aktif', true)
            ->findAll();
    }
}
