<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';

    protected $allowedFields = [
        'id_satuan_kerja',
        'nama_kegiatan',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
