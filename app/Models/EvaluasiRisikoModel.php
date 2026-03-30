<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluasiRisikoModel extends Model
{
    protected $table            = 'evaluasi_risiko';
    protected $primaryKey       = 'id_evaluasi';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'id_identifikasi',
        'id_penilaian',
        'opsi_tindakan',
        'prioritas',
        'keterangan',
        'status_evaluasi'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'id_identifikasi' => 'required|integer',
        'opsi_tindakan'   => 'required|in_list[Menghindari,Membagi,Mengurangi,Menerima,Mengejar]',
    ];

    protected $validationMessages = [
        'id_identifikasi' => [
            'required' => 'Identifikasi risiko harus dipilih.'
        ],
        'opsi_tindakan' => [
            'required' => 'Opsi tindakan harus dipilih.'
        ]
    ];

    protected $skipValidation = false;



    /*
    |--------------------------------------------------------------------------
    | Custom Query
    |--------------------------------------------------------------------------
    */

    public function getEvaluasiLengkap()
    {
        return $this->select('evaluasi_risiko.*, identifikasi_risiko.risiko')
            ->join('identifikasi_risiko', 'identifikasi_risiko.id_identifikasi = evaluasi_risiko.id_identifikasi')
            ->findAll();
    }

    public function getByIdentifikasi($id_identifikasi)
    {
        return $this->where('id_identifikasi', $id_identifikasi)
            ->first();
    }
}
