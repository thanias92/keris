<?php

namespace App\Models;

use CodeIgniter\Model;

class KonteksModel extends Model
{
    protected $table            = 'konteks';
    protected $primaryKey       = 'id_konteks';

    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'id_tim',
        'pemilik_risiko_id',
        'pengelola_risiko_id',
        'id_kegiatan',
        'tahun',
        'id_sasaran_strategis',
        'status',
    ];

    /**
     * Ambil semua konteks (untuk card filter)
     */
    public function getAll()
    {
        return $this
            ->select('
            konteks.*,
            tim_kerja.nama_tim,
            p.nama as nama_pemilik,
            g.nama as nama_pengelola
        ')
            ->join('tim_kerja', 'tim_kerja.id_tim = konteks.id_tim', 'left')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
            ->orderBy('tahun', 'DESC')
            ->orderBy('tim_kerja.nama_tim', 'ASC')
            ->findAll();
    }

    /**
     * Ambil 1 konteks lengkap (future-ready)
     */
    public function getById($id_konteks)
    {
        return $this->where('id_konteks', $id_konteks)->first();
    }

    /**
     * Buat draft konteks baru dari Ruang Lingkup
     */
    public function createDraft(array $data)
    {
        $data['status'] = 'draft';

        $this->insert($data);

        return $this->getInsertID();
    }

    /**
     * Tandai konteks selesai
     */
    public function markAsCompleted($idKonteks)
    {
        return $this->update($idKonteks, [
            'status' => 'lengkap',
        ]);
    }
}
