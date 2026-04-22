<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameKolomTimKerja extends Migration
{
    public function up()
    {
        // Rename kolom di PostgreSQL
        $this->db->query('ALTER TABLE tim_kerja RENAME COLUMN id_satuan_kerja TO id_tim');
        $this->db->query('ALTER TABLE tim_kerja RENAME COLUMN nama_satuan_kerja TO nama_tim');
    }

    public function down()
    {
        // Rollback
        $this->db->query('ALTER TABLE tim_kerja RENAME COLUMN id_tim TO id_satuan_kerja');
        $this->db->query('ALTER TABLE tim_kerja RENAME COLUMN nama_tim TO nama_satuan_kerja');
    }
}
