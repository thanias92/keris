<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemangkuKepentingan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pemangku' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_instansi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'hubungan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
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

        $this->forge->addKey('id_pemangku', true);
        $this->forge->createTable('pemangku_kepentingan', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemangku_kepentingan', true);
    }
}
