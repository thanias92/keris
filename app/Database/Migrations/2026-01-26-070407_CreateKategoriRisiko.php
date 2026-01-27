<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriRisiko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kategori_risiko' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
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

        $this->forge->addKey('id_kategori_risiko', true);
        $this->forge->createTable('kategori_risiko', true);
    }

    public function down()
    {
        $this->forge->dropTable('kategori_risiko', true);
    }
}
