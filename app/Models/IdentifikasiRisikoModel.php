<?php

namespace App\Models;

use CodeIgniter\Model;

class IdentifikasiRisikoModel extends Model
{
    protected $table      = 'identifikasi_risiko';
    protected $primaryKey = 'id_identifikasi';

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_proses',
        'kode_risiko',
        'uraian_kegiatan',
        'pernyataan_risiko',
        'dampak_risiko',
        'penyebab_risiko',
    ];

    protected $useTimestamps = true;
}
