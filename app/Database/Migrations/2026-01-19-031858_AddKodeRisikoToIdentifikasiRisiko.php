<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKodeRisikoToIdentifikasiRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('identifikasi_risiko', [
            'kode_risiko' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
                'after'      => 'id_konteks',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('identifikasi_risiko', 'kode_risiko');
    }
}
