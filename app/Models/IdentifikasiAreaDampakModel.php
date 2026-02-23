<?php

namespace App\Models;

use CodeIgniter\Model;

class IdentifikasiAreaDampakModel extends Model
{
    protected $table = 'identifikasi_area_dampak';
    protected $allowedFields = [
        'id_identifikasi',
        'id_area_dampak'
    ];
}
