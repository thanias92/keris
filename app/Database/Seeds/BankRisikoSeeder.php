<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BankRisikoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['pernyataan_risiko' => 'Keterlambatan pelaksanan tahapan kegiatan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Lemahnya pengendalian wilayah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Keterlambatan dan ketidaktertiban administrasi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Pengadaan dan pendistribusian instrumen dan perlengkapan petugas terlambat', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Rendahnya kompetensi petugas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Rendahnya pemahaman pegawai terhadap materi pelatihan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Terjadinya tumpang tindih (overlap) dan unit usaha terlewat (missed unit)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Data prelist tidak akurat', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Tidak tercapainya target unit usaha di wilayah konsentrasi ekonomi strategis', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Rendahnya partisipasi dan kepedulian internal pegawai terhadap keberhasilan pelaksanaan kegiatan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Rendahnya dukungan dan keterlibatan Eksternal', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Rendahnya efektivitas publisitas digital', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Keterlambatan pengendalian mutu dan penanganan permasalahan lapangan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Ketidaktepatan penugasan petugas dan pembagian wilayah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Keterlambatan pemasukan data', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Risiko belum terpantaunya progres dan kualitas pendataan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Belum tersedianya rule validasi sejak awal pendataan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Anomali tidak ditindaklanjuti', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Realisasi capaian jauh dari target capaian [undercoverage].', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Rendahnya kualitas data', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Kesalahan interpretasi data', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Keterlambatan pencairan anggaran', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Tumpang tindih peran serta tanggung jawab organik atau mitra.', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Keterlambatan penyelesaian kegiatan pendataan.', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Kendala dalam penggunaan aplikasi CAPI.', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Ketidaktersediaan atau penolakan responden.', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Kejadian force majeure.', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Penyalahgunaan data dan keuangan atau kebocoran data.', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Intervensi pihak eksternal.', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Terjadinya anomali data.', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['pernyataan_risiko' => 'Keterlambatan proses penyusunan laporan.', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('bank_risiko')->insertBatch($data);
    }
}
