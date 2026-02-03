<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KriteriaKemungkinanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'level' => 1,
                'deskripsi' => 'Hampir tidak terjadi',
            ],
            [
                'level' => 2,
                'deskripsi' => 'Jarang terjadi',
            ],
            [
                'level' => 3,
                'deskripsi' => 'Kadang terjadi',
            ],
            [
                'level' => 4,
                'deskripsi' => 'Sering terjadi',
            ],
            [
                'level' => 5,
                'deskripsi' => 'Hampir pasti terjadi',
            ],
        ];

        $this->db->table('kriteria_kemungkinan')->insertBatch($data);
    }
}
