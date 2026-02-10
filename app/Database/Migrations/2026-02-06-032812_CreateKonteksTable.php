<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKonteksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_konteks' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            // konteks operasional
            'satuan_kerja' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'pengelola_risiko' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'tahun' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],

            // konteks strategis
            'id_sasaran_strategis' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_konteks', true);
        $this->forge->addForeignKey(
            'id_sasaran_strategis',
            'sasaran_strategis',
            'id_sasaran_strategis',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('konteks');
    }

    public function down()
    {
        $this->forge->dropTable('konteks');
    }
}
