<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveUraianKegiatanFromIdentifikasiRisiko extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('identifikasi_risiko', 'uraian_kegiatan');
    }

    public function down()
    {
        $this->forge->addColumn('identifikasi_risiko', [
            'uraian_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }
}
