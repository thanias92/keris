<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUraianPengendalianToPenilaianRisiko extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE penilaian_risiko ADD COLUMN IF NOT EXISTS uraian_pengendalian TEXT');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE penilaian_risiko DROP COLUMN IF EXISTS uraian_pengendalian');
    }
}
