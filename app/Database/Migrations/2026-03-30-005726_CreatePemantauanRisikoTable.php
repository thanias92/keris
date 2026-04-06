<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemantauanRisikoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pemantauan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_rtp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'realisasi_output' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'realisasi_waktu' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => false,
                'default'    => 'Belum Dilaksanakan',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => 'now()',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => 'now()',
            ],
        ]);

        $this->forge->addKey('id_pemantauan', true); // PRIMARY KEY
        $this->forge->addUniqueKey('id_rtp');

        $this->forge->createTable('pemantauan_risiko');

        // Foreign key tidak didukung langsung oleh forge di PostgreSQL,
        // gunakan query mentah
        $this->db->query('
            ALTER TABLE pemantauan_risiko
            ADD CONSTRAINT fk_pemantauan_rtp
            FOREIGN KEY (id_rtp)
            REFERENCES rencana_penanganan_risiko(id_rtp)
            ON DELETE CASCADE
        ');
    }

    public function down()
    {
        $this->forge->dropTable('pemantauan_risiko', true);
    }
}
