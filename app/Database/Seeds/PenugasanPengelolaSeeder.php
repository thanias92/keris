<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenugasanPengelolaSeeder extends Seeder
{
    public function run()
    {
        // Mapping: satuan_kerja_id => pengelola_id
        // Berdasarkan data 2025, dipasangkan ke satuan kerja 2026
        // id pengelola dari tabel pengelola_risiko
        // id satuan kerja dari tabel satuan_kerja

        $data2025 = [
            // satuan_kerja_id  => pengelola_id
            2  => 10, // Umum & Perencanaan             → Marthasari Julita Tambunan (id:10)
            3  => 10, // Administrasi Keuangan & Pengadaan → Marthasari Julita Tambunan (id:10)
            4  => 16, // Statistik Sosial               → Meita Komalasari — belum ada di DB, skip
            5  => 2,  // Statistik Produksi             → Muji Basuki (id:2)
            6  => 3,  // Statistik Distribusi & Jasa    → Dr. Fitri Hariyanti (id:3)
            7  => 4,  // Neraca Wilayah & Analisis Statistik → Achmad Sobari (id:4)
            8  => 8,  // Diseminasi Layanan Statistik   → Dadang Sunandar (id:8)
            9  => 8,  // Integrasi Pengolahan Data...   → Dadang Sunandar (id:8)
            11 => 1,  // Statistik Sektoral & UKK       → Emilia Dharmayanthi (id:1)
            12 => 6,  // Kehumasan, Protokol, & Medsos  → Irfarial (id:6)
            13 => 13, // Pengendalian Kegiatan Organisasi → Sri Mulyani (id:13)
            14 => 10, // Bagian Umum                    → Marthasari Julita Tambunan (id:10)
        ];

        // Satuan kerja yang tidak ada di data 2025:
        // id:1  SDM & Hukum           → tidak ada datanya, skip
        // id:4  Statistik Sosial      → Meita Komalasari belum ada di pengelola_risiko, skip
        // id:10 Infrastruktur TI & Sains Data → tidak ada datanya, skip

        $now = date('Y-m-d H:i:s');
        $rows = [];

        foreach ($data2025 as $satuanKerjaId => $pengelolaId) {
            $rows[] = [
                'pengelola_id'    => $pengelolaId,
                'satuan_kerja_id' => $satuanKerjaId,
                'tahun'           => 2025,
                'is_ketua_tim'    => true,
                'created_at'      => $now,
            ];
        }

        // Hapus data 2025 yang mungkin sudah ada sebelumnya, lalu insert ulang
        $this->db->table('penugasan_pengelola')
            ->where('tahun', 2025)
            ->delete();

        $this->db->table('penugasan_pengelola')->insertBatch($rows);

        echo "Seeder PenugasanPengelola 2025 selesai.\n";
        echo "Catatan: Statistik Sosial (id:4), SDM & Hukum (id:1), dan Infrastruktur TI & Sains Data (id:10) dilewati karena data pengelolanya belum tersedia.\n";
    }
}
