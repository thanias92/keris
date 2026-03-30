<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengelolaRisikoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Emilia Dharmayanthi, SST, M.Si.',
                'nip' => '197905132000122002',
                'jabatan' => 'Statistisi Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Muji Basuki, SST, M.Si',
                'nip' => '197405121996121001',
                'jabatan' => 'Statistisi Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Dr. Fitri Hariyanti, SST, M.M.',
                'nip' => '197909182000122003',
                'jabatan' => 'Statistisi Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Achmad Sobari, SST, SE., M.Si',
                'nip' => '197809092000121006',
                'jabatan' => 'Statistisi Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Afdi Rizal, SST, M.T',
                'nip' => '198609092009021005',
                'jabatan' => 'Pranata Komputer Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Irfarial, SE',
                'nip' => '196704191994011001',
                'jabatan' => 'Statistisi Ahli Madya Seksi Statistik Harga Konsumen dan Harga Perdagangan Besar',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Syaifudin, SST',
                'nip' => '198209012006021001',
                'jabatan' => 'Statistisi Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Dadang Sunandar SST, MT',
                'nip' => '198311082007011004',
                'jabatan' => 'Pranata Komputer Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Dedi Irawan, S.E.',
                'nip' => '198010172005021002',
                'jabatan' => 'Analis Pengelolaan Keuangan APBN Ahli Madya Bagian Umum',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Marthasari Julita Tambunan, SST, M.M.',
                'nip' => '198007112003122002',
                'jabatan' => 'Analis Pengelolaan Keuangan APBN Ahli Madya Bagian Umum',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Amrizal, SST, M.M.',
                'nip' => '197111111992011004',
                'jabatan' => 'Analis SDM Aparatur Ahli Madya Bagian Umum',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Khaerul Anas, SST., MT',
                'nip' => '198510272009021002',
                'jabatan' => 'Pranata Komputer Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Sri Mulyani, SST, M.Stat',
                'nip' => '198309212007012004',
                'jabatan' => 'Statistisi Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Prayudho Bagus Jatmiko SST, M.Si',
                'nip' => '197612201999121001',
                'jabatan' => 'Kepala Bagian Umum',
                'wilayah_id' => 1,
            ],
            [
                'nama' => 'Meita Komalasari, SST, M.Si',
                'nip' => '197905012000122000',
                'jabatan' => 'Statistisi Ahli Madya BPS Provinsi',
                'wilayah_id' => 1,
            ],
        ];

        foreach ($data as &$row) {
            $row['is_pemilik'] = false;
            $row['aktif'] = true;
            $row['created_at'] = date('Y-m-d H:i:s');
            $row['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db->table('pengelola_risiko')->insertBatch($data);
    }
}
