<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaDampakModel extends Model
{
    protected $table = 'kriteria_dampak';
    protected $primaryKey = 'id_kriteria';

    protected $allowedFields = [
        'level',
        'deskripsi',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}