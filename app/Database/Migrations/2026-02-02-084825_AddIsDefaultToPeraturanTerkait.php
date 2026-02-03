<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsDefaultToPeraturanTerkait extends Migration
{
    public function up()
    {
        $this->forge->addColumn('peraturan_terkait', [
            'is_default' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'null'       => false,
                'after'      => 'nama_peraturan',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('peraturan_terkait', 'is_default');
    }
}
