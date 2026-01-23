<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeKodeKonteksNotNull extends Migration
{
    public function up()
    {
        $this->db->query(
            'ALTER TABLE penetapan_konteks
             ALTER COLUMN kode_konteks SET NOT NULL'
        );
    }

    public function down()
    {
        $this->db->query(
            'ALTER TABLE penetapan_konteks
             ALTER COLUMN kode_konteks DROP NOT NULL'
        );
    }
}
