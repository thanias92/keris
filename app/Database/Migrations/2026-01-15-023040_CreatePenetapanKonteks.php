<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenetapanKonteks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_konteks' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],

            // Identitas kegiatan
            'nama_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'unit_kerja' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
                'null' => false,
            ],
            'penanggung_jawab' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],

            // Tujuan & sasaran
            'tujuan_kegiatan' => [
                'type' => 'TEXT',
            ],
            'sasaran' => [
                'type' => 'TEXT',
            ],
            'indikator_keberhasilan' => [
                'type' => 'TEXT',
            ],

            // Ruang lingkup & asumsi
            'ruang_lingkup' => [
                'type' => 'TEXT',
            ],
            'asumsi' => [
                'type' => 'TEXT',
            ],
            'keterbatasan' => [
                'type' => 'TEXT',
            ],

            // Lingkungan risiko
            'faktor_internal' => [
                'type' => 'TEXT',
            ],
            'faktor_eksternal' => [
                'type' => 'TEXT',
            ],

            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP NULL',
        ]);

        $this->forge->addKey('id_konteks', true);
        $this->forge->createTable('penetapan_konteks');
    }


    public function down()
    {
        //
    }
}
