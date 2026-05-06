<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameSatuanKerjaIdToTimKerjaId extends Migration
{
    public function up()
    {
        // Drop FK lama
        $this->db->query("
            ALTER TABLE penugasan_pengelola
            DROP CONSTRAINT fk_penugasan_satuan_kerja
        ");

        // Rename column
        $this->db->query("
            ALTER TABLE penugasan_pengelola
            RENAME COLUMN satuan_kerja_id TO tim_kerja_id
        ");

        // Tambah FK baru
        $this->db->query("
            ALTER TABLE penugasan_pengelola
            ADD CONSTRAINT fk_penugasan_tim_kerja
            FOREIGN KEY (tim_kerja_id)
            REFERENCES tim_kerja(id_tim)
            ON UPDATE CASCADE
            ON DELETE CASCADE
        ");
    }

    public function down()
    {
        // Drop FK baru
        $this->db->query("
            ALTER TABLE penugasan_pengelola
            DROP CONSTRAINT fk_penugasan_tim_kerja
        ");

        // Balikin nama column
        $this->db->query("
            ALTER TABLE penugasan_pengelola
            RENAME COLUMN tim_kerja_id TO satuan_kerja_id
        ");

        // Balikin FK lama
        $this->db->query("
            ALTER TABLE penugasan_pengelola
            ADD CONSTRAINT fk_penugasan_satuan_kerja
            FOREIGN KEY (satuan_kerja_id)
            REFERENCES tim_kerja(id_tim)
            ON UPDATE CASCADE
            ON DELETE CASCADE
        ");
    }
}
