<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KriteriaDampakSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'level' => 1,
                'nama_level' => 'Tidak Signifikan',
                'deskripsi' => 'Pengaruh terhadap capaian tujuan sangat rendah',
            ],
            [
                'level' => 2,
                'nama_level' => 'Minor',
                'deskripsi' => 'Pengaruh terhadap capaian tujuan rendah',
            ],
            [
                'level' => 3,
                'nama_level' => 'Moderat',
                'deskripsi' => 'Pengaruh terhadap capaian tujuan sedang',
            ],
            [
                'level' => 4,
                'nama_level' => 'Signifikan',
                'deskripsi' => 'Pengaruh terhadap capaian tujuan besar',
            ],
            [
                'level' => 5,
                'nama_level' => 'Sangat Signifikan',
                'deskripsi' => 'Pengaruh terhadap capaian tujuan sangat besar',
            ],
        ];

        foreach ($data as $row) {
            $existing = $this->db->table('kriteria_dampak')
                ->where('level', $row['level'])
                ->get()
                ->getRow();

            if ($existing) {
                // UPDATE jika sudah ada
                $this->db->table('kriteria_dampak')
                    ->where('level', $row['level'])
                    ->update($row);
            } else {
                // INSERT jika belum ada
                $this->db->table('kriteria_dampak')->insert($row);
            }
        }
    }
}
