<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDeskripsiFromKriteriaKemungkinan extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('kriteria_kemungkinan', 'deskripsi');
    }

    public function down()
    {
        $this->forge->addColumn('kriteria_kemungkinan', [
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => false,
            ],
        ]);
    }
}
