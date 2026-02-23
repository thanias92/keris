<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSnapshotColumnsToPenilaianRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penilaian_risiko', [
            'nilai_risiko' => [
                'type' => 'INT',
                'null' => true,
            ],
            'warna_risiko' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'efektivitas' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],
            'status_penilaian' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'draft',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('penilaian_risiko', [
            'nilai_risiko',
            'warna_risiko',
            'efektivitas',
            'status_penilaian'
        ]);
    }
}
