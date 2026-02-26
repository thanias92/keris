<?php

namespace App\Models;

use CodeIgniter\Model;

class KonteksPemangkuModel extends Model
{
    protected $table = 'konteks_pemangku';
    protected $primaryKey = 'id_konteks_pemangku';

    protected $allowedFields = [
        'id_konteks',
        'id_pemangku',
    ];

    protected $returnType = 'array';
}
