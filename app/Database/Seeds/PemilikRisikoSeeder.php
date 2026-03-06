<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PemilikRisikoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Asep Riyadi, S.Si, M.M.',
                'nip' => '196701181989011001',
                'jabatan' => 'Kepala BPS Provinsi Riau',
                'wilayah_id' => 1, // Provinsi Riau
                'is_pemilik' => true,
                'is_pengelola' => false,
                'aktif' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('pengelola_risiko')->insertBatch($data);
    }
}
