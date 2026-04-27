<?php

namespace App\Models;

use CodeIgniter\Model;

class BuktiPemantauanModel extends Model
{
    protected $table          = 'bukti_pemantauan';
    protected $primaryKey     = 'id_bukti';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_pemantauan',
        'url_link',
        'created_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'id_pemantauan' => [
            'label' => 'Pemantauan',
            'rules' => 'required|integer',
        ],
        'url_link' => [
            'label' => 'Link Bukti',
            'rules' => 'required|valid_url',
        ],
    ];

    protected $validationMessages = [
        'id_pemantauan' => [
            'required' => 'ID Pemantauan wajib diisi.',
            'integer'  => 'ID Pemantauan harus berupa angka.',
        ],
        'url_link' => [
            'required'  => 'Link bukti wajib diisi.',
            'valid_url' => 'Format link tidak valid.',
        ],
    ];

    /* ======================================================
       QUERY HELPERS
    ====================================================== */

    public function getByPemantauan(int $idPemantauan): array
    {
        return $this->where('id_pemantauan', $idPemantauan)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    public function countByPemantauan(int $idPemantauan): int
    {
        return $this->where('id_pemantauan', $idPemantauan)->countAllResults();
    }

    /**
     * Simpan link bukti
     */
    public function simpanLink(int $idPemantauan, string $url): int
    {
        $this->insert([
            'id_pemantauan' => $idPemantauan,
            'url_link'      => $url,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return (int) $this->getInsertID();
    }

    /**
     * Hapus semua bukti berdasarkan pemantauan
     */
    public function hapusSemuaByPemantauan(int $idPemantauan): void
    {
        $this->where('id_pemantauan', $idPemantauan)->delete();
    }

    /**
     * Hapus satu bukti (tanpa file)
     */
    public function hapus(int $idBukti): bool
    {
        return (bool) $this->delete($idBukti);
    }
}