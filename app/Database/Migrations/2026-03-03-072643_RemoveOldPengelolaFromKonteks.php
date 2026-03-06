<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveOldPengelolaFromKonteks extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('konteks', 'pengelola_risiko');
    }

    public function down()
    {
        $this->forge->addColumn('konteks', [
            'pengelola_risiko' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
            ],
        ]);
    }
}
