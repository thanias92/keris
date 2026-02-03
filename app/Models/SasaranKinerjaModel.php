<?php

namespace App\Models;

use CodeIgniter\Model;

class SasaranKinerjaModel extends Model
{
    protected $table            = 'sasaran_kinerja';
    protected $primaryKey       = 'id_sasaran';

    protected $allowedFields    = [
        'id_proses',
        'kode_sasaran',
        'uraian_sasaran',
    ];

    protected $useTimestamps = true;

    protected $returnType = 'array';
}
