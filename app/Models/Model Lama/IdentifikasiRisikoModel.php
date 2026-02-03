<?php

namespace App\Models;

use CodeIgniter\Model;

class IdentifikasiRisikoModel extends Model
{
    protected $table      = 'identifikasi_risiko';
    protected $primaryKey = 'id_identifikasi';

    protected $allowedFields = [
        'id_konteks',
        'kode_risiko',
        'uraian_kegiatan',
        'indikator',
        'pernyataan_risiko',
        'penyebab_risiko',
        'dampak_risiko',
        'kategori_risiko',
        'sumber_risiko',
    ];

    protected $useTimestamps = false;
    public function generateKodeRisiko(): string
    {
        $last = $this->select('kode_risiko')
            ->orderBy('id_identifikasi', 'DESC')
            ->first();

        if ($last && preg_match('/R-(\d+)/', $last['kode_risiko'], $m)) {
            $next = (int)$m[1] + 1;
        } else {
            $next = 1;
        }

        return 'R-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
