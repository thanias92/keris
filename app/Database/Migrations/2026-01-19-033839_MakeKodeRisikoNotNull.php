<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeKodeRisikoNotNull extends Migration
{
    public function up()
    {
        $this->db->query(
            'ALTER TABLE identifikasi_risiko
             ALTER COLUMN kode_risiko SET NOT NULL'
        );
    }

    public function down()
    {
        $this->db->query(
            'ALTER TABLE identifikasi_risiko
             ALTER COLUMN kode_risiko DROP NOT NULL'
        );
    }
}
