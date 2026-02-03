<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaKemungkinanModel extends Model
{
    protected $table = 'kriteria_kemungkinan';
    protected $primaryKey = 'id_kriteria';

    protected $allowedFields = [
        'level',
        'deskripsi',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}