<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePenilaianRisikoAddTipe extends Migration
{
    public function up()
    {
        // 1. Tambah kolom tipe_penilaian
        $this->forge->addColumn('penilaian_risiko', [
            'tipe_penilaian' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
                'default'    => 'AWAL',
                'after'      => 'id_identifikasi',
            ],
        ]);

        // 2. CHECK constraint: hanya AWAL atau RESIDU
        $this->db->query(
            "ALTER TABLE penilaian_risiko
             ADD CONSTRAINT chk_tipe_penilaian
             CHECK (tipe_penilaian IN ('AWAL', 'RESIDU'))"
        );

        // 3. Hapus unique lama (kalau ada) di id_identifikasi
        // karena sekarang unique-nya gabungan
        $this->db->query(
            "DROP INDEX IF EXISTS penilaian_risiko_id_identifikasi"
        );

        // 4. Tambah UNIQUE gabungan (id_identifikasi + tipe_penilaian)
        $this->db->query(
            "ALTER TABLE penilaian_risiko
             ADD CONSTRAINT uk_penilaian_identifikasi_tipe
             UNIQUE (id_identifikasi, tipe_penilaian)"
        );
    }

    public function down()
    {
        // rollback opsional
        $this->db->query(
            "ALTER TABLE penilaian_risiko
             DROP CONSTRAINT IF EXISTS uk_penilaian_identifikasi_tipe"
        );

        $this->db->query(
            "ALTER TABLE penilaian_risiko
             DROP CONSTRAINT IF EXISTS chk_tipe_penilaian"
        );

        $this->forge->dropColumn('penilaian_risiko', 'tipe_penilaian');

        // (opsional) restore unique lama
        $this->db->query(
            "ALTER TABLE penilaian_risiko
             ADD CONSTRAINT uk_penilaian_identifikasi
             UNIQUE (id_identifikasi)"
        );
    }
}
