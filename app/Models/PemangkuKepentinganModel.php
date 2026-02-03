<?php

namespace App\Models;

use CodeIgniter\Model;

class PemangkuKepentinganModel extends Model
{
    protected $table            = 'pemangku_kepentingan';
    protected $primaryKey       = 'id_pemangku';

    protected $allowedFields    = [
        'nama_instansi',
        'hubungan',
    ];

    protected $useTimestamps = true;

    protected $returnType = 'array';
}
