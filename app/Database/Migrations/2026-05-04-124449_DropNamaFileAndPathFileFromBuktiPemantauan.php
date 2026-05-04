<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropNamaFileAndPathFileFromBuktiPemantauan extends Migration
{
    public function up()
    {
        // Drop kolom yang tidak dipakai
        $this->forge->dropColumn('bukti_pemantauan', ['nama_file', 'path_file']);
    }

    public function down()
    {
        // Restore kolom jika rollback
        $this->forge->addColumn('bukti_pemantauan', [
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
        ]);
    }
}
