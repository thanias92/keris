<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSasaranKinerja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sasaran' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_proses' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'kode_sasaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
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

        $this->forge->addKey('id_sasaran', true);
        $this->forge->addKey('id_proses');
        $this->forge->addForeignKey(
            'id_proses',
            'proses_bisnis',
            'id_proses',
            'CASCADE',
            'RESTRICT'
        );

        $this->forge->createTable('sasaran_kinerja', true);
    }

    public function down()
    {
        $this->forge->dropTable('sasaran_kinerja', true);
    }
}
