<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDampakRisikoToIdentifikasiRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('identifikasi_risiko', [
            'dampak_risiko' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'penyebab_risiko',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('identifikasi_risiko', 'dampak_risiko');
    }
}
