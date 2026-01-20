<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIdentifikasiRisiko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_identifikasi' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],

            // FK ke penetapan_konteks
            'id_konteks' => [
                'type' => 'INT',
                'null' => false,
            ],

            // Identifikasi risiko
            'uraian_kegiatan' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'indikator' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pernyataan_risiko' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'penyebab_risiko' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Klasifikasi
            'kategori_risiko' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'sumber_risiko' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],

            // Timestamp (POSTGRES SAFE)
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP NULL',
        ]);

        $this->forge->addKey('id_identifikasi', true);
        $this->forge->addKey('id_konteks');

        $this->forge->createTable('identifikasi_risiko');
    }


    public function down()
    {
        //
    }
}
