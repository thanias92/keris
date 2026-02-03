<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeraturanTerkaitSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_peraturan' => 'Undang-undang No. 16 tahun 1997 tentang Statistik',
                'is_default'     => true,
            ],
            [
                'nama_peraturan' => 'Peraturan Pemerintah No. 51 tahun 1999 tentang Penyelenggaraan Statistik',
                'is_default'     => true,
            ],
            [
                'nama_peraturan' => 'Peraturan Pemerintah No. 60 Tahun 2008 tentang Sistem Pengendalian Intern Pemerintah',
                'is_default'     => true,
            ],
        ];

        $this->db->table('peraturan_terkait')->insertBatch($data);
    }
}
