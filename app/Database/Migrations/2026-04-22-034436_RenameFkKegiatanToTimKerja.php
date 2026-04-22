<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameFkKegiatanToTimKerja extends Migration
{
    public function up()
    {
        // 1. Drop FK lama (pakai nama yang BENAR)
        $this->db->query('ALTER TABLE kegiatan DROP CONSTRAINT IF EXISTS kegiatan_id_satuan_kerja_foreign');

        // 2. Rename kolom
        $this->db->query('ALTER TABLE kegiatan RENAME COLUMN id_satuan_kerja TO id_tim');

        // 3. Tambah FK baru
        $this->db->query('ALTER TABLE kegiatan ADD CONSTRAINT kegiatan_id_tim_foreign 
            FOREIGN KEY (id_tim) REFERENCES tim_kerja(id_tim) ON DELETE CASCADE');
    }

    public function down()
    {
        // rollback

        $this->db->query('ALTER TABLE kegiatan DROP CONSTRAINT IF EXISTS kegiatan_id_tim_foreign');

        $this->db->query('ALTER TABLE kegiatan RENAME COLUMN id_tim TO id_satuan_kerja');

        $this->db->query('ALTER TABLE kegiatan ADD CONSTRAINT kegiatan_id_satuan_kerja_foreign 
            FOREIGN KEY (id_satuan_kerja) REFERENCES tim_kerja(id_tim) ON DELETE CASCADE');
    }
}
