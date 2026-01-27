<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAreaDampak extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_area_dampak' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_area_dampak' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
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

        $this->forge->addKey('id_area_dampak', true);
        $this->forge->createTable('area_dampak', true);
    }

    public function down()
    {
        $this->forge->dropTable('area_dampak', true);
    }
}
