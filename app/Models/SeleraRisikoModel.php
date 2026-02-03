<?php

namespace App\Models;

use CodeIgniter\Model;

class SeleraRisikoModel extends Model
{
    protected $table            = 'selera_risiko';
    protected $primaryKey       = 'id_selera';

    protected $allowedFields    = [
        'level_risiko',
        'nilai_min',
        'nilai_max',
        'warna',
        'tindakan',
    ];

    protected $useTimestamps = true;

    protected $returnType = 'array';
}
