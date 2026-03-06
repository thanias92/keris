<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSatuanKerjaToPengelolaRisiko extends Migration
{
    public function up()
    {
        // tambah kolom
        $this->forge->addColumn('pengelola_risiko', [
            'id_satuan_kerja' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'wilayah_id'
            ],
        ]);

        // tambah foreign key
        $this->db->query("
            ALTER TABLE pengelola_risiko
            ADD CONSTRAINT fk_pengelola_risiko_satuan_kerja
            FOREIGN KEY (id_satuan_kerja)
            REFERENCES satuan_kerja(id_satuan_kerja)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ");
    }

    public function down()
    {
        // hapus FK dulu
        $this->db->query("
            ALTER TABLE pengelola_risiko
            DROP CONSTRAINT IF EXISTS fk_pengelola_risiko_satuan_kerja
        ");

        // hapus kolom
        $this->forge->dropColumn('pengelola_risiko', 'id_satuan_kerja');
    }
}
