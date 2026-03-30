<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResiduColumnsToRencanaPenangananRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('rencana_penanganan_risiko', [
            'id_kemungkinan_residu' => [
                'type'       => 'INT',
                'null'       => true,
                'after'      => 'target_waktu',
            ],
            'id_dampak_residu' => [
                'type'       => 'INT',
                'null'       => true,
                'after'      => 'id_kemungkinan_residu',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rencana_penanganan_risiko', 'id_kemungkinan_residu');
        $this->forge->dropColumn('rencana_penanganan_risiko', 'id_dampak_residu');
    }
}
