<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MatriksRisikoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // level_kemungkinan, level_dampak, nilai_risiko, warna

            // Level 1
            ['level_kemungkinan' => 1, 'level_dampak' => 1, 'nilai_risiko' => 1, 'warna' => 'biru'],
            ['level_kemungkinan' => 1, 'level_dampak' => 2, 'nilai_risiko' => 3, 'warna' => 'biru'],
            ['level_kemungkinan' => 1, 'level_dampak' => 3, 'nilai_risiko' => 5, 'warna' => 'biru'],
            ['level_kemungkinan' => 1, 'level_dampak' => 4, 'nilai_risiko' => 8, 'warna' => 'hijau'],
            ['level_kemungkinan' => 1, 'level_dampak' => 5, 'nilai_risiko' => 20, 'warna' => 'merah'],

            // Level 2
            ['level_kemungkinan' => 2, 'level_dampak' => 1, 'nilai_risiko' => 2, 'warna' => 'biru'],
            ['level_kemungkinan' => 2, 'level_dampak' => 2, 'nilai_risiko' => 7, 'warna' => 'hijau'],
            ['level_kemungkinan' => 2, 'level_dampak' => 3, 'nilai_risiko' => 11, 'warna' => 'kuning'],
            ['level_kemungkinan' => 2, 'level_dampak' => 4, 'nilai_risiko' => 13, 'warna' => 'kuning'],
            ['level_kemungkinan' => 2, 'level_dampak' => 5, 'nilai_risiko' => 21, 'warna' => 'merah'],

            // Level 3
            ['level_kemungkinan' => 3, 'level_dampak' => 1, 'nilai_risiko' => 4, 'warna' => 'biru'],
            ['level_kemungkinan' => 3, 'level_dampak' => 2, 'nilai_risiko' => 10, 'warna' => 'hijau'],
            ['level_kemungkinan' => 3, 'level_dampak' => 3, 'nilai_risiko' => 14, 'warna' => 'kuning'],
            ['level_kemungkinan' => 3, 'level_dampak' => 4, 'nilai_risiko' => 17, 'warna' => 'oranye'],
            ['level_kemungkinan' => 3, 'level_dampak' => 5, 'nilai_risiko' => 22, 'warna' => 'merah'],

            // Level 4
            ['level_kemungkinan' => 4, 'level_dampak' => 1, 'nilai_risiko' => 6, 'warna' => 'hijau'],
            ['level_kemungkinan' => 4, 'level_dampak' => 2, 'nilai_risiko' => 12, 'warna' => 'kuning'],
            ['level_kemungkinan' => 4, 'level_dampak' => 3, 'nilai_risiko' => 16, 'warna' => 'oranye'],
            ['level_kemungkinan' => 4, 'level_dampak' => 4, 'nilai_risiko' => 19, 'warna' => 'oranye'],
            ['level_kemungkinan' => 4, 'level_dampak' => 5, 'nilai_risiko' => 24, 'warna' => 'merah'],

            // Level 5
            ['level_kemungkinan' => 5, 'level_dampak' => 1, 'nilai_risiko' => 9, 'warna' => 'hijau'],
            ['level_kemungkinan' => 5, 'level_dampak' => 2, 'nilai_risiko' => 15, 'warna' => 'kuning'],
            ['level_kemungkinan' => 5, 'level_dampak' => 3, 'nilai_risiko' => 18, 'warna' => 'oranye'],
            ['level_kemungkinan' => 5, 'level_dampak' => 4, 'nilai_risiko' => 23, 'warna' => 'merah'],
            ['level_kemungkinan' => 5, 'level_dampak' => 5, 'nilai_risiko' => 25, 'warna' => 'merah'],
        ];

        $this->db->table('matriks_risiko')->insertBatch($data);
    }
}
