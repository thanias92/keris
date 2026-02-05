<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriRisikoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Kebijakan'],
            ['nama_kategori' => 'Kepatuhan'],
            ['nama_kategori' => 'Legal'],
            ['nama_kategori' => 'Reputasi'],
            ['nama_kategori' => 'Operasional'],
            ['nama_kategori' => 'Fraud'],
            ['nama_kategori' => 'Kemitraan'],
            ['nama_kategori' => 'Kontingensi'],
            ['nama_kategori' => 'Aplikasi (SPBE)'],
            ['nama_kategori' => 'Keamanan'],
            ['nama_kategori' => 'Infrastruktur'],
        ];

        $this->db->table('kategori_risiko')->insertBatch($data);
    }
}
