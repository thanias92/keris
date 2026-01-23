<?php

namespace App\Models;

use CodeIgniter\Model;

class PenetapanKonteksModel extends Model
{
    protected $table      = 'penetapan_konteks';
    protected $primaryKey = 'id_konteks';

    protected $allowedFields = [
        'kode_konteks',
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

    protected $useTimestamps = false;
    public function generateKodeKonteks(): string
    {
        $last = $this->select('kode_konteks')
            ->orderBy('id_konteks', 'DESC')
            ->first();

        if ($last && preg_match('/K-(\d+)/', $last['kode_konteks'], $m)) {
            $next = (int)$m[1] + 1;
        } else {
            $next = 1;
        }

        return 'K-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
