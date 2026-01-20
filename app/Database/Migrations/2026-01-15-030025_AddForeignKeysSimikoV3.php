<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeysSimikoV3 extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // identifikasi_risiko -> penetapan_konteks
        $db->query("
            ALTER TABLE identifikasi_risiko
            ADD CONSTRAINT fk_identifikasi_konteks
            FOREIGN KEY (id_konteks)
            REFERENCES penetapan_konteks(id_konteks)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
        ");

        // rencana_tindak -> identifikasi_risiko
        $db->query("
            ALTER TABLE rencana_tindak
            ADD CONSTRAINT fk_rencana_identifikasi
            FOREIGN KEY (id_identifikasi)
            REFERENCES identifikasi_risiko(id_identifikasi)
            ON UPDATE CASCADE
            ON DELETE CASCADE
        ");

        // penilaian_risiko -> identifikasi_risiko
        $db->query("
            ALTER TABLE penilaian_risiko
            ADD CONSTRAINT fk_penilaian_identifikasi
            FOREIGN KEY (id_identifikasi)
            REFERENCES identifikasi_risiko(id_identifikasi)
            ON UPDATE CASCADE
            ON DELETE CASCADE
        ");

        // penilaian_risiko -> rencana_tindak (nullable)
        $db->query("
            ALTER TABLE penilaian_risiko
            ADD CONSTRAINT fk_penilaian_rencana
            FOREIGN KEY (id_rencana_tindak)
            REFERENCES rencana_tindak(id_rencana_tindak)
            ON UPDATE CASCADE
            ON DELETE SET NULL
        ");
    }

    public function down()
    {
        $db = \Config\Database::connect();

        $db->query("ALTER TABLE penilaian_risiko DROP CONSTRAINT fk_penilaian_rencana");
        $db->query("ALTER TABLE penilaian_risiko DROP CONSTRAINT fk_penilaian_identifikasi");
        $db->query("ALTER TABLE rencana_tindak DROP CONSTRAINT fk_rencana_identifikasi");
        $db->query("ALTER TABLE identifikasi_risiko DROP CONSTRAINT fk_identifikasi_konteks");
    }
}
