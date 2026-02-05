<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterSeleraRisikoTable extends Migration
{
    public function up()
    {
        // Tambah kolom level (angka 1–5)
        $this->forge->addColumn('selera_risiko', [
            'level' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'id_selera',
            ],
        ]);

        // Tambah nama level (Sangat Rendah, dst)
        $this->forge->addColumn('selera_risiko', [
            'nama_level' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'level',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('selera_risiko', 'nama_level');
        $this->forge->dropColumn('selera_risiko', 'level');
    }
}
