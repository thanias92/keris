<?php

namespace App\Models;

use CodeIgniter\Model;

class KonteksProsesBisnisModel extends Model
{
    protected $table      = 'konteks_proses_bisnis';
    protected $primaryKey = 'id_konteks_proses';

    protected $allowedFields = [
        'id_konteks',
        'id_proses',
    ];

    protected $useTimestamps = false;

    public function getByKonteks($idKonteks)
    {
        return $this->db->table('konteks_proses_bisnis kpb')
            ->select('
            kpb.id_konteks_proses,
            kpb.id_konteks,
            kpb.id_proses,
            pb.kode_proses,
            pb.jenis_proses,
            pb.uraian_proses
        ')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->where('kpb.id_konteks', $idKonteks)
            ->orderBy("CASE WHEN pb.jenis_proses = 'Teknis' THEN 1 ELSE 2 END", '', false)
            ->orderBy('pb.kode_proses', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function syncByKonteks($idKonteks, array $idProsesList)
    {
        // hapus yang lama
        $this->where('id_konteks', $idKonteks)->delete();

        // insert yang baru
        foreach ($idProsesList as $idProses) {
            $this->insert([
                'id_konteks' => $idKonteks,
                'id_proses'  => $idProses,
            ]);
        }
    }
}
