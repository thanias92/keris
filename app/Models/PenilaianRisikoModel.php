<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianRisikoModel extends Model
{
    protected $table      = 'penilaian_risiko';
    protected $primaryKey = 'id_penilaian';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_identifikasi',
        'kemungkinan',
        'dampak',
        'nilai_risiko',
        'level_risiko',
        'warna_level',
        'tingkat_risiko',
        'pengendalian_eksisting',
        'efektivitas_pengendalian',
        'catatan_analisis',
        'jenis_penilaian',
        'tanggal_penilaian',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * VALIDATION RULES
     */
    protected $validationRules = [
        'id_identifikasi' => 'required|integer',
        'kemungkinan'     => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'dampak'          => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'nilai_risiko'    => 'required|integer',
        'level_risiko' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'warna_level'  => 'required|string|max_length[10]',
        'tingkat_risiko'  => 'required|string|max_length[50]',
        'pengendalian_eksisting' => 'required|string',
        'efektivitas_pengendalian' => 'required|in_list[Efektif,Kurang Efektif,Tidak Efektif]',
        'jenis_penilaian' => 'required|in_list[Aktual,Residual]',
        'tanggal_penilaian' => 'required|valid_date',
    ];

    protected $validationMessages = [
        'id_identifikasi' => [
            'required' => 'Identifikasi risiko wajib diisi',
        ],
        'kemungkinan' => [
            'required' => 'Nilai kemungkinan wajib diisi',
        ],
        'dampak' => [
            'required' => 'Nilai dampak wajib diisi',
        ],
        'pengendalian_eksisting' => [
            'required' => 'Pengendalian yang telah dilakukan wajib diisi',
        ],
        'efektivitas_pengendalian' => [
            'in_list' => 'Efektivitas harus Efektif / Kurang Efektif / Tidak Efektif',
        ],
    ];
}
