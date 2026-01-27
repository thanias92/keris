<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSasaranStrategis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sasaran_strategis' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_sasaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'uraian_sasaran' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_sasaran_strategis', true);

        // kode sasaran sebaiknya unik (S1, S2, dst)
        $this->forge->addUniqueKey(
            'kode_sasaran',
            'uk_sasaran_strategis_kode'
        );

        $this->forge->createTable('sasaran_strategis', true);
    }

    public function down()
    {
        $this->forge->dropTable('sasaran_strategis', true);
    }
}
