<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEvaluasiRisikoTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE evaluasi_risiko (
                id_evaluasi SERIAL PRIMARY KEY,
                id_identifikasi INT4 NOT NULL,
                id_penilaian INT4,
                opsi_tindakan VARCHAR(30) NOT NULL,
                prioritas VARCHAR(20) DEFAULT NULL,
                keterangan TEXT,
                status_evaluasi VARCHAR(20) DEFAULT 'draft',
                created_at TIMESTAMP DEFAULT NOW(),
                updated_at TIMESTAMP DEFAULT NOW(),

                CONSTRAINT fk_evaluasi_identifikasi
                    FOREIGN KEY (id_identifikasi)
                    REFERENCES identifikasi_risiko(id_identifikasi)
                    ON DELETE CASCADE,

                CONSTRAINT fk_evaluasi_penilaian
                    FOREIGN KEY (id_penilaian)
                    REFERENCES penilaian_risiko(id_penilaian)
                    ON DELETE SET NULL
            );
        ");
    }

    public function down()
    {
        $this->db->query("DROP TABLE IF EXISTS evaluasi_risiko");
    }
}
