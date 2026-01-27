<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKriteriaKemungkinan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kriteria' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'level' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => false,
            ],
            'deskripsi' => [
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

        $this->forge->addKey('id_kriteria', true);
        $this->forge->addUniqueKey('level');
        $this->forge->createTable('kriteria_kemungkinan', true);
    }

    public function down()
    {
        $this->forge->dropTable('kriteria_kemungkinan', true);
    }
}
