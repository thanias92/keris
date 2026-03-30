<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PemangkuKepentinganSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Data yang sudah ada di tabel (skip jika sudah ada, insert jika belum)
            ['nama_instansi' => 'Kepala Badan Pusat Statistik', 'hubungan' => 'Pimpinan Lembaga'],
            ['nama_instansi' => 'Inspektur Utama', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Biro Umum', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Biro Keuangan', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Deputi Bidang Metodologi dan Informasi Statistik', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Deputi Bidang Statistik Sosial', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Deputi Bidang Statistik Produksi', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Deputi Bidang Statistik Distribusi dan Jasa', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Deputi Bidang Neraca dan Analisis Statistik', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Inspektorat Utama', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Biro Perencanaan dan Kerja Sama', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Biro Keuangan dan Barang Milik Negara', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Biro Sumber Daya Manusia', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Biro Hukum dan Organisasi', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Biro Umum dan Hubungan Masyarakat', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Pusat Pendidikan dan Pelatihan', 'hubungan' => 'Pembina'],
            ['nama_instansi' => 'Politeknik Statistika STIS', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Metodologi Statistik dan Sains Data', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Diseminasi, Pemberdayaan, dan Evaluasi Penyelenggaraan Statistik', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Sistem Informasi Statistik', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Statistik Kependudukan dan Ketenagakerjaan', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Statistik Kesejahteraan Rakyat', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Statistik Ketahanan Sosial', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Statistik Sumber Daya Hayati', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Statistik Sumber Daya Mineral dan Konstruksi', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Statistik Industri', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Statistik Distribusi', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Statistik Harga', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Statistik Jasa', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Neraca Produksi', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Neraca Pengeluaran', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Direktorat Analisis Statistik dan Neraca Satelit', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Inspektorat I', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Inspektorat II', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Inspektorat III', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'BPS Provinsi/Kab/Kota', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana SDM dan Hukum BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Perencanaan dan Umum BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Keuangan dan Pengadaan BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Statistik Sosial BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Statistik Produksi BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Statistik Distribusi BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Nerwilis BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Diseminasi dan Layanan Statistik BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana IPD dan PAS BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Infrastruktur TI dan Sains Data BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Statistik Sektoral dan UKK BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Kehumasan, Protokoler dan Media Sosial BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Pembangunan Zona Integritas BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Sensus Ekonomi 2026 BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Tim Pelaksana Unit dibawah Kepala Bagian Umum BPS Provinsi Riau', 'hubungan' => 'Mitra kerja internal'],
            ['nama_instansi' => 'Badan Koordinasi Penanaman Modal (BPKM)', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Badan Pemeriksa Keuangan', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Badan Perencanaan Pembangunan Daerah', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Bappedalitbang Provinsi Riau', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Bupati dan Walikota se-Provinsi Riau', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Dinas Pariwisata', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu (DPMPTSP)', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Dinas Perindustrian, Perdagangan, Koperasi dan UMKM', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Dinas Perkebunan Kabupaten', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Dinas Perkebunan Provinsi Riau', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Dinas Tenaga Kerja dan Transmigrasi', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Dinas/OPD di lingkungan Pemerintah Provinsi Riau', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Diskominfotik Provinsi Riau', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Diskominfotik Kab/Kota se-Riau', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Ditjen Perbendaharaan Kantor Wilayah Riau', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Instansi Vertikal di lingkungan Pemerintah Provinsi Riau', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Kantor Pelayanan dan Perbendaharaan Negara Pekanbaru', 'hubungan' => 'Mitra kerja eksternal'],
            ['nama_instansi' => 'Kantor Pelayanan Kekayaan Negara dan Lelang', 'hubungan' => 'Mitra kerja eksternal'],
        ];

        // Gunakan insertOrIgnore agar data yang sudah ada tidak duplikat
        foreach ($data as $row) {
            $exists = $this->db->table('pemangku_kepentingan')
                ->where('nama_instansi', $row['nama_instansi'])
                ->countAllResults();

            if ($exists === 0) {
                $this->db->table('pemangku_kepentingan')->insert($row);
            }
        }
    }
}
