<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SatuanKerjaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_satuan_kerja' => 'SDM & Hukum'],
            ['nama_satuan_kerja' => 'Umum & Perencanaan'],
            ['nama_satuan_kerja' => 'Keuangan & PBJ'],
            ['nama_satuan_kerja' => 'Statistik Sosial'],
            ['nama_satuan_kerja' => 'Statistik Produksi'],
            ['nama_satuan_kerja' => 'Statistik Distribusi'],
            ['nama_satuan_kerja' => 'Nerwilis'],
            ['nama_satuan_kerja' => 'DLS'],
            ['nama_satuan_kerja' => 'IPD & PAS'],
            ['nama_satuan_kerja' => 'Infrastruktur TI & SD'],
            ['nama_satuan_kerja' => 'Sektoral & UKK'],
            ['nama_satuan_kerja' => 'Humas & Protokoler'],
        ];

        $this->db->table('satuan_kerja')->insertBatch($data);
    }
}
