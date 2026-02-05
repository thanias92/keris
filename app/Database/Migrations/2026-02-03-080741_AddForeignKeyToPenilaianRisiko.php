<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeyToPenilaianRisiko extends Migration
{
    public function up()
    {
        // kemungkinan
        $this->forge->addForeignKey(
            'id_kemungkinan',
            'kriteria_kemungkinan',
            'id_kriteria',
            'CASCADE',
            'RESTRICT'
        );

        // dampak
        $this->forge->addForeignKey(
            'id_dampak',
            'kriteria_dampak',
            'id_kriteria',
            'CASCADE',
            'RESTRICT'
        );

        // matriks
        $this->forge->addForeignKey(
            'id_matriks',
            'matriks_risiko',
            'id_matriks',
            'CASCADE',
            'SET NULL'
        );

        // selera
        $this->forge->addForeignKey(
            'id_selera',
            'selera_risiko',
            'id_selera',
            'CASCADE',
            'SET NULL'
        );

        $this->forge->processIndexes('penilaian_risiko');
    }

    public function down()
    {
        $this->forge->dropForeignKey('penilaian_risiko', 'penilaian_risiko_id_kemungkinan_foreign');
        $this->forge->dropForeignKey('penilaian_risiko', 'penilaian_risiko_id_dampak_foreign');
        $this->forge->dropForeignKey('penilaian_risiko', 'penilaian_risiko_id_matriks_foreign');
        $this->forge->dropForeignKey('penilaian_risiko', 'penilaian_risiko_id_selera_foreign');
    }
}
