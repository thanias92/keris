<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianRisikoModel extends Model
{
    protected $table      = 'penilaian_risiko';
    protected $primaryKey = 'id_penilaian';

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_identifikasi',
        'tindakan',
        'tipe_penilaian',
        'id_kemungkinan',
        'id_dampak',
        'id_matriks',
        'id_selera',
        'nilai_risiko',
        'warna_risiko',
        'efektivitas',
        'uraian_pengendalian',
    ];

    protected $useTimestamps = true;
}
