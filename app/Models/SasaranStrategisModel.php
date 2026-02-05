<?php

namespace App\Models;

use CodeIgniter\Model;

class SasaranStrategisModel extends Model
{
    protected $table      = 'sasaran_strategis';
    protected $primaryKey = 'id_sasaran_strategis';

    protected $returnType = 'array';

    protected $allowedFields = [
        'kode_sasaran',
        'uraian_sasaran',
    ];

    protected $useTimestamps = true;
}
