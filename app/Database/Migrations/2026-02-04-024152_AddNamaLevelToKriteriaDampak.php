<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNamaLevelToKriteriaDampak extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kriteria_dampak', [
            'nama_level' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'level',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kriteria_dampak', 'nama_level');
    }
}
