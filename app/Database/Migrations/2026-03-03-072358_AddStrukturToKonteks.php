<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStrukturToKonteks extends Migration
{
    public function up()
    {
        $this->forge->addColumn('konteks', [
            'pemilik_risiko_id' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'id_konteks',
            ],
            'pengelola_risiko_id' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'pemilik_risiko_id',
            ],
        ]);

        $this->forge->addForeignKey(
            'pemilik_risiko_id',
            'pengelola_risiko',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'pengelola_risiko_id',
            'pengelola_risiko',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->processIndexes('konteks');
    }

    public function down()
    {
        $this->forge->dropForeignKey('konteks', 'konteks_pemilik_risiko_id_foreign');
        $this->forge->dropForeignKey('konteks', 'konteks_pengelola_risiko_id_foreign');
        $this->forge->dropColumn('konteks', ['pemilik_risiko_id', 'pengelola_risiko_id']);
    }
}
