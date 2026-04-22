<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameFkKonteksToTimKerja extends Migration
{
    public function up()
    {
        // 1. Drop FK lama (INI YANG BENAR)
        $this->db->query('ALTER TABLE konteks DROP CONSTRAINT IF EXISTS fk_konteks_satuan_kerja');

        // 2. Rename kolom
        $this->db->query('ALTER TABLE konteks RENAME COLUMN id_satuan_kerja TO id_tim');

        // 3. Tambah FK baru
        $this->db->query('ALTER TABLE konteks ADD CONSTRAINT fk_konteks_tim 
            FOREIGN KEY (id_tim) REFERENCES tim_kerja(id_tim) ON DELETE CASCADE');
    }

    public function down()
    {
        // rollback

        $this->db->query('ALTER TABLE konteks DROP CONSTRAINT IF EXISTS fk_konteks_tim');

        $this->db->query('ALTER TABLE konteks RENAME COLUMN id_tim TO id_satuan_kerja');

        $this->db->query('ALTER TABLE konteks ADD CONSTRAINT fk_konteks_satuan_kerja 
            FOREIGN KEY (id_satuan_kerja) REFERENCES tim_kerja(id_tim) ON DELETE CASCADE');
    }
}
