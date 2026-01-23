<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKodeKonteksToPenetapanKonteks extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penetapan_konteks', [
            'kode_konteks' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('penetapan_konteks', 'kode_konteks');
    }
}
