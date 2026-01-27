<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIdentifikasiAreaDampak extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_identifikasi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_area_dampak' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        // Composite Primary Key
        $this->forge->addKey(['id_identifikasi', 'id_area_dampak'], true);

        // Foreign Keys
        $this->forge->addForeignKey(
            'id_identifikasi',
            'identifikasi_risiko',
            'id_identifikasi',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'id_area_dampak',
            'area_dampak',
            'id_area_dampak',
            'CASCADE',
            'RESTRICT'
        );

        $this->forge->createTable('identifikasi_area_dampak', true);
    }

    public function down()
    {
        $this->forge->dropTable('identifikasi_area_dampak', true);
    }
}
