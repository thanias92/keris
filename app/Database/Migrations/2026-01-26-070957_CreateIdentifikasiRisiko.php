<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIdentifikasiRisiko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_identifikasi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_proses' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'kode_risiko' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'uraian_kegiatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pernyataan_risiko' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'dampak_risiko' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'penyebab_risiko' => [
                'type' => 'TEXT',
                'null' => true,
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

        $this->forge->addKey('id_identifikasi', true);
        $this->forge->addKey('id_proses');

        $this->forge->addForeignKey(
            'id_proses',
            'proses_bisnis',
            'id_proses',
            'CASCADE',
            'RESTRICT'
        );

        $this->forge->createTable('identifikasi_risiko', true);
    }

    public function down()
    {
        $this->forge->dropTable('identifikasi_risiko', true);
    }
}
