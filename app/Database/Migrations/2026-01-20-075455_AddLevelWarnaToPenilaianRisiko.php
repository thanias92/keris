<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLevelWarnaToPenilaianRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penilaian_risiko', [
            'level_risiko' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => false,
                'after' => 'nilai_risiko',
                'comment' => 'Level risiko 1-5',
            ],
            'warna_level' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
                'after' => 'level_risiko',
                'comment' => 'Warna risiko (biru/hijau/kuning/oranye/merah)',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('penilaian_risiko', ['level_risiko', 'warna_level']);
    }
}
