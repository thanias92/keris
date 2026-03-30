<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBankRisikoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bank_risiko' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'pernyataan_risiko' => [
                'type' => 'TEXT',
                'null' => false,
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

        $this->forge->addKey('id_bank_risiko', true);
        $this->forge->createTable('bank_risiko', true);
    }

    public function down()
    {
        $this->forge->dropTable('bank_risiko', true);
    }
}
