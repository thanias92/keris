<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSumberRisikoToIdentifikasiRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('identifikasi_risiko', [
            'sumber_risiko' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'id_kategori_risiko'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('identifikasi_risiko', 'sumber_risiko');
    }
}
