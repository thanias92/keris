<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SasaranStrategisSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['kode_sasaran' => 'P1111', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Kependudukan Dan Ketenagakerjaan Yang Berkualitas'],
            ['kode_sasaran' => 'P1131', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Kesejahteraan Rakyat Yang Berkualitas'],
            ['kode_sasaran' => 'P1151', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Ketahanan Sosial Yang Berkualitas'],
            ['kode_sasaran' => 'P1211', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Tanaman Pangan, Hortikultura, dan Perkebunan yang Berkualitas'],
            ['kode_sasaran' => 'P1221', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Peternakan, Perikanan, dan Kehutanan yang Berkualitas'],
            ['kode_sasaran' => 'P1231', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Industri yang Berkualitas'],
            ['kode_sasaran' => 'P1311', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Distribusi yang Berkualitas'],
            ['kode_sasaran' => 'P1331', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Harga yang Berkualitas'],
            ['kode_sasaran' => 'P1351', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Keuangan, Teknologi Informasi, dan Pariwisata yang Berkualitas'],
            ['kode_sasaran' => 'P1411', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Neraca Produksi yang Berkualitas'],
            ['kode_sasaran' => 'P1412', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Statistik Neraca Pengeluaran yang Berkualitas'],
            ['kode_sasaran' => 'P1413', 'uraian_sasaran' => 'Persentase Publikasi/Laporan Analisis dan Pengembangan Statistik yang Berkualitas'],
            ['kode_sasaran' => 'P1441', 'uraian_sasaran' => 'Indeks Keberhasilan Penyediaan Indikator Sasaran Visi Indonesia Emas dan 45 Indikator Utama Pembangunan'],
            ['kode_sasaran' => 'P2141', 'uraian_sasaran' => 'Persentase Kumulatif Desa Yang Berpredikat Desa Cinta Statistik'],
            ['kode_sasaran' => 'P2511', 'uraian_sasaran' => 'Tingkat Penyelenggaraan Pembinaan Statistik Sektoral sesuai standar'],
            ['kode_sasaran' => 'P2611', 'uraian_sasaran' => 'Persentase Kegiatan Edukasi dan Promosi Statistik yang terselenggara dengan baik'],
            ['kode_sasaran' => 'P2711', 'uraian_sasaran' => 'Indikator Pelayanan Publik - Penilaian Mandiri'],
            ['kode_sasaran' => 'P3241', 'uraian_sasaran' => 'Nilai SAKIP oleh Inspektorat'],
            ['kode_sasaran' => 'P3242', 'uraian_sasaran' => 'Nilai BerAkhlak'],
            ['kode_sasaran' => 'P3251', 'uraian_sasaran' => 'Tingkat Keberhasilan Pembangunan Zona Integritas'],
        ];

        $this->db->table('sasaran_strategis')->insertBatch($data);
    }
}
