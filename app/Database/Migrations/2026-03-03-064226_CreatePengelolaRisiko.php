<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengelolaRisiko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'SERIAL',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'wilayah_id' => [
                'type' => 'INT',
            ],
            'is_pemilik' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'is_pengelola' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'aktif' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('wilayah_id', 'wilayah', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengelola_risiko');
    }

    public function down()
    {
        $this->forge->dropTable('pengelola_risiko');
    }
}
