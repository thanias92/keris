<?php

namespace App\Models;

use CodeIgniter\Model;

class KonteksPeraturanModel extends Model
{
    protected $table = 'konteks_peraturan';
    protected $primaryKey = 'id_konteks_peraturan';

    protected $allowedFields = [
        'id_konteks',
        'id_peraturan',
    ];

    protected $returnType = 'array';
}
