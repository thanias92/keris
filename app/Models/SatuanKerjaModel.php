<?php

namespace App\Models;

use CodeIgniter\Model;

class SatuanKerjaModel extends Model
{
    protected $table            = 'satuan_kerja';
    protected $primaryKey       = 'id_satuan_kerja';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $allowedFields    = [
        'nama_satuan_kerja',
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Helper khusus dropdown
     * hasil: [id => nama]
     */
    public function getDropdown()
    {
        return $this->orderBy('nama_satuan_kerja', 'ASC')
            ->findAll();
    }
}
