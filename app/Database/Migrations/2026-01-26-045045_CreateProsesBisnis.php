<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProsesBisnis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_proses' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_proses' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
            'jenis_proses' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'comment'    => 'TEKNIS atau NON_TEKNIS',
            ],
            'uraian_proses' => [
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

        $this->forge->addKey('id_proses', true);
        $this->forge->addUniqueKey('kode_proses');
        $this->forge->createTable('proses_bisnis', true);
    }

    public function down()
    {
        $this->forge->dropTable('proses_bisnis', true);
    }
}
