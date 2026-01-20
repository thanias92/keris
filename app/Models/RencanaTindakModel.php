<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaTindakModel extends Model
{
    protected $table      = 'rencana_tindak';
    protected $primaryKey = 'id_rencana_tindak';

    protected $allowedFields = [
        'id_identifikasi',
        'tindakan_pengendalian',
        'penanggung_jawab',
        'target_waktu',
        'status_tindak_lanjut',
        'keterangan',
    ];

    protected $useTimestamps = false;
}
