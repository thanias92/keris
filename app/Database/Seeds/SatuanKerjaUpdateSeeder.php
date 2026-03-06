<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SatuanKerjaUpdateSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $table = $db->table('satuan_kerja');

        $data = [
            'SDM & Hukum',
            'Umum & Perencanaan',
            'Administrasi Keuangan & Pengadaan',
            'Statistik Sosial',
            'Statistik Produksi',
            'Statistik Distribusi & Jasa',
            'Neraca Wilayah & Analisis Statistik',
            'Diseminasi Layanan Statistik',
            'Integrasi Pengolahan Data & Pengembangan Sistem Informasi Statistik',
            'Infrastruktur TI & Sains Data',
            'Statistik Sektoral & UKK',
            'Kehumasan, Protokol, & Medsos',            
            'Pengendalian Kegiatan Organisasi',
            'Bagian Umum'
        ];

        foreach ($data as $nama) {

            $exists = $table
                ->where('nama_satuan_kerja', $nama)
                ->get()
                ->getRow();

            if (!$exists) {

                $table->insert([
                    'nama_satuan_kerja' => $nama
                ]);

                echo "INSERT: $nama\n";
            } else {

                echo "SKIP: $nama sudah ada\n";
            }
        }

        echo "Seeder selesai.\n";
    }
}
