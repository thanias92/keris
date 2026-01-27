<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRencanaPenangananRisiko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rtp' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penilaian_awal' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'uraian_rtp' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'target_output' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'target_waktu' => [
                'type' => 'DATE',
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

        $this->forge->addKey('id_rtp', true);
        $this->forge->addKey('id_penilaian_awal');

        $this->forge->addForeignKey(
            'id_penilaian_awal',
            'penilaian_risiko',
            'id_penilaian',
            'CASCADE',
            'RESTRICT',
            'fk_rtp_penilaian_awal'
        );

        $this->forge->createTable('rencana_penanganan_risiko', true);
    }

    public function down()
    {
        $this->forge->dropTable('rencana_penanganan_risiko', true);
    }
}