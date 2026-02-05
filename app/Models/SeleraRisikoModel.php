<?php

namespace App\Models;

use CodeIgniter\Model;

class SeleraRisikoModel extends Model
{
    protected $table            = 'selera_risiko';
    protected $primaryKey       = 'id_selera';

    protected $returnType       = 'array';
    protected $useSoftDeletes  = false;
    protected $useTimestamps   = true;

    protected $allowedFields = [
        'level',            // 1 – 5
        'nama_level',       // Sangat Rendah, Rendah, dst
        'nilai_min',        // batas bawah nilai risiko
        'nilai_max',        // batas atas nilai risiko
        'warna',            // biru, hijau, kuning, oranye, merah
        'tindakan',         // narasi tindakan
    ];
}
