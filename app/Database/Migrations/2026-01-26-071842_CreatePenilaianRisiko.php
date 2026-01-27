<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenilaianRisiko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penilaian' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_identifikasi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'level_kemungkinan' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => false,
            ],
            'level_dampak' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => false,
            ],
            'nilai_risiko' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'level_risiko' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'warna' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'tindakan' => [
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

        $this->forge->addKey('id_penilaian', true);
        $this->forge->addKey('id_identifikasi');

        // Satu identifikasi = satu penilaian aktif
        $this->forge->addUniqueKey(
            'id_identifikasi',
            'uk_penilaian_risiko_identifikasi'
        );

        $this->forge->addForeignKey(
            'id_identifikasi',
            'identifikasi_risiko',
            'id_identifikasi',
            'CASCADE',
            'RESTRICT'
        );

        $this->forge->createTable('penilaian_risiko', true);
    }

    public function down()
    {
        $this->forge->dropTable('penilaian_risiko', true);
    }
}
