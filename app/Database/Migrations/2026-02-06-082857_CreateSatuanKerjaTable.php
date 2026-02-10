<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSatuanKerjaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_satuan_kerja' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_satuan_kerja' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_satuan_kerja', true);
        $this->forge->addUniqueKey('nama_satuan_kerja');
        $this->forge->createTable('satuan_kerja');
    }

    public function down()
    {
        $this->forge->dropTable('satuan_kerja');
    }
}
