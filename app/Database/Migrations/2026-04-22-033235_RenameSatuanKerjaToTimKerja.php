<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameSatuanKerjaToTimKerja extends Migration
{
    public function up()
    {
        // Rename table
        $this->forge->renameTable('satuan_kerja', 'tim_kerja');
    }

    public function down()
    {
        // Rollback rename
        $this->forge->renameTable('tim_kerja', 'satuan_kerja');
    }
}
