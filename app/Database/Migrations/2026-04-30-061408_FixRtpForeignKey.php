<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixRtpForeignKey extends Migration
{
    public function up()
    {
        // 🔥 DROP FK lama
        $this->db->query("
            ALTER TABLE rencana_penanganan_risiko
            DROP CONSTRAINT IF EXISTS fk_rtp_penilaian_awal
        ");

        // 🔥 ADD FK baru ke evaluasi_risiko
        $this->db->query("
            ALTER TABLE rencana_penanganan_risiko
            ADD CONSTRAINT fk_rtp_evaluasi
            FOREIGN KEY (id_penilaian_awal)
            REFERENCES evaluasi_risiko(id_evaluasi)
            ON DELETE CASCADE
        ");
    }

    public function down()
    {
        // rollback: balikin ke kondisi lama (optional, tapi bagus untuk safety)

        $this->db->query("
            ALTER TABLE rencana_penanganan_risiko
            DROP CONSTRAINT IF EXISTS fk_rtp_evaluasi
        ");

        $this->db->query("
            ALTER TABLE rencana_penanganan_risiko
            ADD CONSTRAINT fk_rtp_penilaian_awal
            FOREIGN KEY (id_penilaian_awal)
            REFERENCES penilaian_risiko(id_penilaian)
            ON DELETE CASCADE
        ");
    }
}
