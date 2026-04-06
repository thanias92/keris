<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropRoleFromUsers extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('users', 'role');
    }

    public function down()
    {
        $this->forge->addColumn('users', [
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
        ]);
    }
}
