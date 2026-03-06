<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterKonteksAddIdKegiatan extends Migration
{
    public function up()
    {
        // tambah kolom id_kegiatan
        $this->forge->addColumn('konteks', [
            'id_kegiatan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);

        // tambah foreign key
        $this->db->query("
            ALTER TABLE konteks
            ADD CONSTRAINT fk_konteks_kegiatan
            FOREIGN KEY (id_kegiatan)
            REFERENCES kegiatan(id_kegiatan)
            ON DELETE CASCADE
        ");

        // hapus kolom kegiatan lama
        $this->forge->dropColumn('konteks', 'kegiatan');
    }

    public function down()
    {
        // rollback

        $this->forge->addColumn('konteks', [
            'kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);

        $this->db->query("
            ALTER TABLE konteks
            DROP CONSTRAINT IF EXISTS fk_konteks_kegiatan
        ");

        $this->forge->dropColumn('konteks', 'id_kegiatan');
    }
}
