<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRencanaTindakToPenilaianRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penilaian_risiko', [
            'id_rencana_tindak' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'id_identifikasi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('penilaian_risiko', 'id_rencana_tindak');
    }
}
