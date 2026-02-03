<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePenilaianRisikoRelation extends Migration
{
    public function up()
    {
        // Hapus kolom lama
        $this->forge->dropColumn('penilaian_risiko', [
            'level_kemungkinan',
            'level_dampak',
            'nilai_risiko',
            'level_risiko',
            'warna'
        ]);

        // Tambah FK baru
        $this->forge->addColumn('penilaian_risiko', [
            'id_kemungkinan' => ['type' => 'INT'],
            'id_dampak' => ['type' => 'INT'],
            'id_matriks' => ['type' => 'INT'],
            'id_selera' => ['type' => 'INT'],
        ]);
    }

    public function down()
    {
        //
    }
}
