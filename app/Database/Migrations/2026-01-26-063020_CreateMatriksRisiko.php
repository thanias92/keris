<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMatriksRisiko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_matriks' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'level_kemungkinan' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => false,
            ],
            'level_dampak' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => false,
            ],
            'nilai_risiko' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
            ],
            'warna' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
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

        $this->forge->addKey('id_matriks', true);

        // kombinasi kemungkinan + dampak harus unik
        $this->forge->addUniqueKey(['level_kemungkinan', 'level_dampak']);

        $this->forge->createTable('matriks_risiko', true);
    }

    public function down()
    {
        $this->forge->dropTable('matriks_risiko', true);
    }
}
