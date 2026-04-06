<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddValidasiToPemantauanRisiko extends Migration
{
    public function up()
    {
        $fields = [
            'status_validasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'default'    => 'Menunggu',
            ],
            'catatan_validasi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'validated_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'validated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('pemantauan_risiko', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pemantauan_risiko', [
            'status_validasi',
            'catatan_validasi',
            'validated_by',
            'validated_at',
        ]);
    }
}
