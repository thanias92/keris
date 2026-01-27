<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeraturanTerkait extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_peraturan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_peraturan' => [
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

        $this->forge->addKey('id_peraturan', true);
        $this->forge->createTable('peraturan_terkait', true);
    }

    public function down()
    {
        $this->forge->dropTable('peraturan_terkait', true);
    }
}
