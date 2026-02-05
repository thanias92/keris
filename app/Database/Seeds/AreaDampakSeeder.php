<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AreaDampakSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_area_dampak' => 'Fraud'],
            ['nama_area_dampak' => 'Penurunan Reputasi'],
            ['nama_area_dampak' => 'Sanksi Pidana, Perdata, dan/atau Administratif'],
            ['nama_area_dampak' => 'Kecelakaan Kerja'],
            ['nama_area_dampak' => 'Gangguan Terhadap Layanan Organisasi'],
        ];

        $this->db->table('area_dampak')->insertBatch($data);
    }
}
