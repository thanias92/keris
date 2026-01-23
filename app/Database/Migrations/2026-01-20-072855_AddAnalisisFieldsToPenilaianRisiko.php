<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAnalisisFieldsToPenilaianRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penilaian_risiko', [
            'pengendalian_eksisting' => [
                'type' => 'TEXT',
                'null' => false,
                'after' => 'tingkat_risiko',
            ],
            'efektivitas_pengendalian' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
                'after' => 'pengendalian_eksisting',
            ],
            'catatan_analisis' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'efektivitas_pengendalian',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('penilaian_risiko', [
            'pengendalian_eksisting',
            'efektivitas_pengendalian',
            'catatan_analisis',
        ]);
    }
}
