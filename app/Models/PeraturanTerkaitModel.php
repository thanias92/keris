<?php

namespace App\Models;

use CodeIgniter\Model;

class PeraturanTerkaitModel extends Model
{
    protected $table      = 'peraturan_terkait';
    protected $primaryKey = 'id_peraturan';

    protected $allowedFields = [
        'nama_peraturan',
        'is_default',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}