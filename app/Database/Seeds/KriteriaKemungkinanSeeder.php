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
                'nama_level' => 'Hampir Tidak Terjadi',
                'deskripsi' => 'Kemungkinan kejadian sangat kecil',
                'persentase_min' => 0,
                'persentase_max' => 5,
                'deskripsi_frekuensi' => 'Sangat jarang: < 2 kali dalam 1 tahun',
            ],
            [
                'level' => 2,
                'nama_level' => 'Jarang Terjadi',
                'deskripsi' => 'Kemungkinan kejadian jarang',
                'persentase_min' => 5,
                'persentase_max' => 10,
                'deskripsi_frekuensi' => 'Jarang: 2–5 kali dalam 1 tahun',
            ],
            [
                'level' => 3,
                'nama_level' => 'Kadang Terjadi',
                'deskripsi' => 'Kemungkinan kejadian sedang',
                'persentase_min' => 10,
                'persentase_max' => 20,
                'deskripsi_frekuensi' => 'Cukup sering: 6–9 kali dalam 1 tahun',
            ],
            [
                'level' => 4,
                'nama_level' => 'Sering Terjadi',
                'deskripsi' => 'Kemungkinan kejadian tinggi',
                'persentase_min' => 20,
                'persentase_max' => 50,
                'deskripsi_frekuensi' => 'Sering: 10–12 kali dalam 1 tahun',
            ],
            [
                'level' => 5,
                'nama_level' => 'Hampir Pasti Terjadi',
                'deskripsi' => 'Kemungkinan kejadian sangat tinggi',
                'persentase_min' => 50,
                'persentase_max' => 100,
                'deskripsi_frekuensi' => 'Sangat sering: > 12 kali dalam 1 tahun',
            ],
        ];
        $this->db->table('kriteria_kemungkinan')->insertBatch($data);
    }
}
