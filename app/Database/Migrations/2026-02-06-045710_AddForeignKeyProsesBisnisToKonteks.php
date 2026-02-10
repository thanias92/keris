<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeyProsesBisnisToKonteks extends Migration
{
    public function up()
    {
        // Tambah foreign key via SQL (AMAN untuk table existing)
        $this->db->query("
            ALTER TABLE proses_bisnis
            ADD CONSTRAINT fk_proses_bisnis_konteks
            FOREIGN KEY (id_konteks)
            REFERENCES konteks(id_konteks)
            ON DELETE CASCADE
            ON UPDATE CASCADE
        ");
    }

    public function down()
    {
        $this->db->query("
            ALTER TABLE proses_bisnis
            DROP CONSTRAINT fk_proses_bisnis_konteks
        ");
    }
}
