<?php

namespace App\Models;

use CodeIgniter\Model;

class PenetapanKonteksModel extends Model
{
    protected $table      = 'penetapan_konteks';
    protected $primaryKey = 'id_konteks';

    protected $allowedFields = [
        'nama_kegiatan',
        'unit_kerja',
        'tahun',
        'penanggung_jawab',
        'tujuan_kegiatan',
        'sasaran',
        'indikator_keberhasilan',
        'ruang_lingkup',
        'asumsi',
        'keterbatasan',
        'faktor_internal',
        'faktor_eksternal',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
