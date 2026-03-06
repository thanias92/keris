<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengelolaRisikoSatuanKerjaSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // mapping dari excel kamu
        $mapping = [
            'SDM & Hukum' => 'Amrizal, SST, M.M.',
            'Umum & Perencanaan' => 'Dedi Irawan, S.E.',
            'Administrasi Keuangan & Pengadaan' => 'Marthasari Julita Tambunan, SST, M.M.',
            'Statistik Sosial' => 'Emilia Dharmayanthi, SST, M.Si.',
            'Statistik Produksi' => 'Muji Basuki, SST, M.Si',
            'Statistik Distribusi & Jasa' => 'Dr. Fitri Hariyanti, SST, M.M.',
            'Neraca Wilayah & Analisis Statistik' => 'Achmad Sobari, SST, SE., M.Si',
            'Diseminasi Layanan Statistik' => 'Syaifudin, SST',
            'Integrasi Pengolahan Data & Pengembangan Sistem Informasi Statistik' => 'Dadang Sunandar SST, MT',
            'Infrastruktur TI & Sains Data' => 'Khaerul Anas, SST., MT',
            'Statistik Sektoral & UKK' => 'Afdi Rizal, SST, M.T',
            'Kehumasan, Protokol, dan Medsos' => 'Irfarial, SE',
            'Pengendalian Kegiatan Organisasi' => 'Sri Mulyani, SST, M.Stat',
            'Bagian Umum' => 'Prayudho Bagus Jatmiko  SST, M.Si'
        ];

        foreach ($mapping as $nama_satuan => $nama_ketua) {

            // cari satuan kerja
            $satuan = $db->table('satuan_kerja')
                ->where('nama_satuan_kerja', $nama_satuan)
                ->get()
                ->getRow();

            // kalau tidak ada -> skip
            if (!$satuan) {
                echo "SKIP SATUAN KERJA: $nama_satuan\n";
                continue;
            }

            // cari pengelola risiko
            $pengelola = $db->table('pengelola_risiko')
                ->where('nama', $nama_ketua)
                ->get()
                ->getRow();

            if (!$pengelola) {
                echo "SKIP PENGELOLA: $nama_ketua\n";
                continue;
            }

            // update id_satuan_kerja
            $db->table('pengelola_risiko')
                ->where('id', $pengelola->id)
                ->update([
                    'id_satuan_kerja' => $satuan->id_satuan_kerja
                ]);
        }

        echo "Seeder selesai.\n";
    }
}
