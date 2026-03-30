<?php

namespace App\Models;

use CodeIgniter\Model;

class BankRisikoModel extends Model
{
    protected $table            = 'bank_risiko';
    protected $primaryKey       = 'id_bank_risiko';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Field yang boleh diisi
    protected $allowedFields = [
        'pernyataan_risiko',
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'pernyataan_risiko' => 'required|min_length[5]|max_length[500]',
    ];

    protected $validationMessages = [
        'pernyataan_risiko' => [
            'required'   => 'Pernyataan risiko wajib diisi.',
            'min_length' => 'Pernyataan risiko minimal 5 karakter.',
            'max_length' => 'Pernyataan risiko maksimal 500 karakter.',
        ],
    ];

    protected $skipValidation = false;

    // =========================================================
    // CUSTOM METHODS
    // =========================================================

    /**
     * Ambil data untuk tabel dengan pagination
     */
    public function getForTable(int $perPage = 10): array
    {
        return $this->orderBy('id_bank_risiko', 'ASC')->paginate($perPage, 'bank_risiko');
    }

    /**
     * Ambil pager instance
     */
    public function getPager()
    {
        return $this->pager;
    }

    /**
     * Ambil semua data aktif untuk dropdown di Identifikasi Risiko
     */
    public function getForDropdown(): array
    {
        return $this->select('id_bank_risiko, pernyataan_risiko')
            ->orderBy('pernyataan_risiko', 'ASC')
            ->findAll();
    }
}
