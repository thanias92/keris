<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianRisikoModel extends Model
{
    protected $table      = 'penilaian_risiko';
    protected $primaryKey = 'id_penilaian';

    protected $allowedFields = [
        'id_identifikasi',
        'id_rencana_tindak',
        'kemungkinan',
        'dampak',
        'nilai_risiko',
        'tingkat_risiko',
        'jenis_penilaian',
        'tanggal_penilaian',
    ];

    protected $useTimestamps = false;
}
