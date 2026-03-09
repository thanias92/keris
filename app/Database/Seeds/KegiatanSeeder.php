<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $data = [

            [1, 'Kenaikan Pangkat Pegawai'],
            [1, 'Ujian Kompetensi'],

            [2, 'Pengelolaan Barang Milik Negara'],
            [2, 'Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP)'],
            [2, 'Arsip dan Rumah Tangga'],

            [3, 'Indikator Kinerja Pelaksanaan Anggaran (IKPA)'],
            [3, 'Arsip Keuangan'],
            [3, 'Pengadaan Barang dan Jasa'],

            [4, 'Survei Angkatan Kerja Nasional (SAKERNAS)'],
            [4, 'Survei Sosial Ekonomi Nasional (SUSENAS)'],
            [4, 'Survei Nasional Literasi dan Inklusi Keuangan (SNLIK)'],
            [4, 'Survei Ekonomi Rumah Tangga Triwulanan (SERUTI)'],
            [4, 'Data Tunggal Sosial dan Ekonomi Nasional (DTSEN)'],
            [4, 'Desa Cinta Statistik (Desa Cantik)'],
            [4, 'Potensi Desa (PODES)'],

            [5, 'Survei Perkebunan Bulanan'],
            [5, 'Survei Kesejahteraan Petani (SKP)'],
            [5, 'Survei Tahunan Perusahaan Industri Manufaktur'],
            [5, 'Survei IBS Triwulanan'],
            [5, 'Survei Triwulanan Pelaku Usaha (STPU)'],
            [5, 'Survei Kerangka Sampel Area (KSA) Padi'],

            [6, 'Survei Harga Produsen (SHP)'],
            [6, 'Survei VHTS (Tingkat Penghunian Kamar Hotel)'],
            [6, 'Survei Harga Konsumen (SHK)'],
            [6, 'Survei Statistik Keuangan Pemerintah Desa (K3)'],
            [6, 'Survei Statistik Lembaga Keuangan (SLK)'],

            [7, 'Penyusunan PDRB Lapangan Usaha'],
            [7, 'Survei Khusus Triwulanan Neraca Produksi (SKTNP)'],
            [7, 'Penyusunan PDRB Pengeluaran'],
            [7, 'Survei Khusus Lembaga Non Profit yang Melayani Rumah Tangga (SKLNP) Triwulanan'],
            [7, 'Survei Khusus Studi Penyusunan Perubahan Inventori (SKSPPI)'],
            [7, 'Penghitungan Angka Indeks Pembangunan Manusia (IPM)'],
            [7, 'Penyusunan Publikasi Isu Terkini'],

            [8, 'Rekomendasi Kegiatan Statistik (Romantik)'],
            [8, 'Layanan Perpustakaan'],
            [8, 'Konsultasi'],
            [8, 'Produk Berbayar'],
            [8, 'Pojok Statistik'],

            [9, 'Wilayah Kerja Statistik (Wilkerstat)'],
            [9, 'Pengembangan Sistem Informasi'],

            [10, 'Manajemen Aset dan Layanan TI'],
            [10, 'Sains Data'],

            [11, 'Pembinaan Statistik Sektoral'],
            [11, 'Upaya Kesehatan Kerja (UKK)'],
            [11, 'Policy Brief'],

            [12, 'Pengelolaan Media Sosial'],
            [12, 'Edukasi Statistik'],
            [12, 'Penyiapan Rilis Berita Resmi Statistik (BRS)'],

            [14, 'Sensus Ekonomi'],
            [14, 'Pembangunan Zona Integritas'],

        ];

        foreach ($data as $row) {

            $id_satuan = $row[0];
            $nama_kegiatan = $row[1];

            $existing = $db->table('kegiatan')
                ->where('id_satuan_kerja', $id_satuan)
                ->where('nama_kegiatan', $nama_kegiatan)
                ->get()
                ->getRow();

            if ($existing) {
                echo "SKIP: $nama_kegiatan\n";
                continue;
            }

            $db->table('kegiatan')->insert([
                'id_satuan_kerja' => $id_satuan,
                'nama_kegiatan'   => $nama_kegiatan
            ]);

            echo "INSERT: $nama_kegiatan\n";
        }

        echo "Seeder kegiatan selesai.\n";
    }
}
