<?php

namespace App\Models;

use CodeIgniter\Model;

class MatriksRisikoModel extends Model
{
    protected $table            = 'matriks_risiko';
    protected $primaryKey       = 'id_matriks';

    protected $allowedFields    = [
        'level_kemungkinan',
        'level_dampak',
        'nilai_risiko',
        'warna',
    ];

    protected $useTimestamps = true;

    protected $returnType = 'array';
}
