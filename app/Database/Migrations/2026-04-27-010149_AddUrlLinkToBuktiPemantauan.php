<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUrlLinkToBuktiPemantauan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bukti_pemantauan', [
            'url_link' => [
                'type'       => 'TEXT',
                'null'       => true, // sementara nullable biar tidak ganggu data lama
                'after'      => 'path_file', // opsional (PostgreSQL ignore ini, tapi aman)
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bukti_pemantauan', 'url_link');
    }
}
