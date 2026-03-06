<?php

namespace App\Models;

use CodeIgniter\Model;

class WilayahModel extends Model
{
    protected $table = 'wilayah';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'kode_wilayah',
        'nama_wilayah',
        'tipe'
    ];

    public function getKabKota()
    {
        return $this
            ->whereIn('tipe', ['kabupaten', 'kota'])
            ->orderBy('kode_wilayah', 'ASC')
            ->findAll();
    }
}
