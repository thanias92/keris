<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategoriToIdentifikasiRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('identifikasi_risiko', [
            'id_kategori_risiko' => [
                'type'       => 'INT',
                'null'       => true,
                'after'      => 'dampak_risiko'
            ],
        ]);

        $this->forge->addForeignKey(
            'id_kategori_risiko',
            'kategori_risiko',
            'id_kategori_risiko',
            'CASCADE',
            'SET NULL'
        );

        $this->forge->processIndexes('identifikasi_risiko');
    }

    public function down()
    {
        $this->forge->dropForeignKey(
            'identifikasi_risiko',
            'identifikasi_risiko_id_kategori_risiko_foreign'
        );

        $this->forge->dropColumn('identifikasi_risiko', 'id_kategori_risiko');
    }
}
