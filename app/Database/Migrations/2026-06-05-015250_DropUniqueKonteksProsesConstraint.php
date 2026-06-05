<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropUniqueKonteksProsesConstraint extends Migration
{
    public function up()
    {
        $this->db->query("
            ALTER TABLE konteks_proses_bisnis
            DROP CONSTRAINT IF EXISTS konteks_proses_bisnis_id_konteks_id_proses_key
        ");
    }

    public function down()
    {
        $this->db->query("
            ALTER TABLE konteks_proses_bisnis
            ADD CONSTRAINT konteks_proses_bisnis_id_konteks_id_proses_key
            UNIQUE (id_konteks, id_proses)
        ");
    }
}
