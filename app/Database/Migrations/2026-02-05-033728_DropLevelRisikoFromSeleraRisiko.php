<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropLevelRisikoFromSeleraRisiko extends Migration
{
    public function up()
    {
        // DROP kolom lama (varchar)
        $this->forge->dropColumn('selera_risiko', 'level_risiko');
    }

    public function down()
    {
        // Restore jika rollback
        $this->forge->addColumn('selera_risiko', [
            'level_risiko' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
        ]);
    }
}
