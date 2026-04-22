<?php

namespace App\Models;

use CodeIgniter\Model;

class TimKerjaModel extends Model
{
    protected $table            = 'tim_kerja';
    protected $primaryKey       = 'id_tim';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $allowedFields    = [
        'nama_tim',
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
        return $this->orderBy('nama_tim', 'ASC')
            ->findAll();
    }
}
