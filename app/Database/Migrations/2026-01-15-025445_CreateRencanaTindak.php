<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRencanaTindak extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rencana_tindak' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],

            // FK ke identifikasi_risiko
            'id_identifikasi' => [
                'type' => 'INT',
                'null' => false,
            ],

            // Isi Form Rencana Tindak
            'tindakan_pengendalian' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'penanggung_jawab' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
            ],
            'target_waktu' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'status_tindak_lanjut' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => false,
                // contoh: direncanakan, proses, selesai
            ],

            // Keterangan tambahan (opsional tapi sering ada di SUPAS)
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Timestamp (PostgreSQL-safe)
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP NULL',
        ]);

        $this->forge->addKey('id_rencana_tindak', true);
        $this->forge->addKey('id_identifikasi');

        $this->forge->createTable('rencana_tindak');
    }

    public function down()
    {
        $this->forge->dropTable('rencana_tindak');
    }
}
