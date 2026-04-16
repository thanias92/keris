<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddApprovalToBankRisiko extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bank_risiko', [
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'approved'
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true
            ],
            'approved_by' => [
                'type' => 'INT',
                'null' => true
            ],
            'approved_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bank_risiko', [
            'status',
            'created_by',
            'approved_by',
            'approved_at',
            'notes'
        ]);
    }
}
