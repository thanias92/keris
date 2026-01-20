<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenilaianRisiko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penilaian' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],

            // FK ke identifikasi_risiko
            'id_identifikasi' => [
                'type' => 'INT',
                'null' => false,
            ],

            // Nilai risiko
            'kemungkinan' => [
                'type' => 'INT',
                'null' => false,
            ],
            'dampak' => [
                'type' => 'INT',
                'null' => false,
            ],

            // Hasil penilaian
            'nilai_risiko' => [
                'type' => 'INT',
                'null' => false,
            ],
            'tingkat_risiko' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],

            // Jenis penilaian
            'jenis_penilaian' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
                // contoh: inherent / residual
            ],

            'tanggal_penilaian' => [
                'type' => 'DATE',
                'null' => false,
            ],

            // Timestamp (PostgreSQL safe)
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP NULL',
        ]);

        $this->forge->addKey('id_penilaian', true);
        $this->forge->addKey('id_identifikasi');

        $this->forge->createTable('penilaian_risiko');
    }


    public function down()
    {
        //
    }
}
