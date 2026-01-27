<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeleraRisiko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_selera' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'level_risiko' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'nilai_min' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'nilai_max' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'warna' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'tindakan' => [
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

        $this->forge->addKey('id_selera', true);
        $this->forge->createTable('selera_risiko', true);
    }

    public function down()
    {
        $this->forge->dropTable('selera_risiko', true);
    }
}
