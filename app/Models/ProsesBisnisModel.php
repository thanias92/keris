<?php

namespace App\Models;

use CodeIgniter\Model;

class ProsesBisnisModel extends Model
{
    protected $table         = 'proses_bisnis';
    protected $primaryKey    = 'id_proses';
    protected $returnType    = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'kode_proses',
        'jenis_proses',
        'uraian_proses',
    ];
}
