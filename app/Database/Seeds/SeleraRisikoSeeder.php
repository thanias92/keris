<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeleraRisikoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'level'       => 1,
                'nama_level'  => 'Sangat Rendah',
                'nilai_min'   => 1,
                'nilai_max'   => 5,
                'warna'       => 'biru',
                'tindakan'    => 'Tidak Diperlukan Tindakan',
            ],
            [
                'level'       => 2,
                'nama_level'  => 'Rendah',
                'nilai_min'   => 6,
                'nilai_max'   => 10,
                'warna'       => 'hijau',
                'tindakan'    => 'Diambil Tindakan Jika Diperlukan',
            ],
            [
                'level'       => 3,
                'nama_level'  => 'Sedang',
                'nilai_min'   => 11,
                'nilai_max'   => 14,
                'warna'       => 'kuning',
                'tindakan'    => 'Diambil Tindakan Jika Sumber Daya Tersedia',
            ],
            [
                'level'       => 4,
                'nama_level'  => 'Tinggi',
                'nilai_min'   => 15,
                'nilai_max'   => 19,
                'warna'       => 'oranye',
                'tindakan'    => 'Diperlukan Tindakan Untuk Mengelola Risiko',
            ],
            [
                'level'       => 5,
                'nama_level'  => 'Sangat Tinggi',
                'nilai_min'   => 20,
                'nilai_max'   => 25,
                'warna'       => 'merah',
                'tindakan'    => 'Diperlukan Tindakan Segera Untuk Mengelola Risiko',
            ],
        ];

        $this->db->table('selera_risiko')->insertBatch($data);
    }
}
