<?php

namespace App\Models;

use CodeIgniter\Model;

class SasaranKinerjaModel extends Model
{
    protected $table         = 'sasaran_kinerja';
    protected $primaryKey    = 'id_sasaran';
    protected $returnType    = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'id_konteks_proses',    
        'uraian_sasaran',
    ];

    public function getByKonteks($idKonteks)
    {
        return $this->db->table('sasaran_kinerja sk')
            ->select('
                sk.*,
                pb.kode_proses,
                pb.jenis_proses,
                pb.uraian_proses as uraian_proses_bisnis
            ')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = sk.id_konteks_proses')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->where('kpb.id_konteks', $idKonteks)
            ->orderBy('pb.kode_proses', 'ASC')
            ->get()
            ->getResultArray();
    }
}
