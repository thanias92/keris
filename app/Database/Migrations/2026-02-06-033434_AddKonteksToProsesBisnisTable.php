<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKonteksToProsesBisnisTable extends Migration
{
    public function up()
    {
        // 1. Tambah kolom id_konteks
        $this->forge->addColumn('proses_bisnis', [
            'id_konteks' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true, // penting: jangan NOT NULL dulu
                'after'    => 'id_proses',
            ],
        ]);

        // 2. Tambah foreign key
        $this->forge->addForeignKey(
            'id_konteks',
            'konteks',
            'id_konteks',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        // Drop foreign key dulu
        $this->forge->dropForeignKey('proses_bisnis', 'proses_bisnis_id_konteks_foreign');

        // Drop kolom
        $this->forge->dropColumn('proses_bisnis', 'id_konteks');
    }
}
