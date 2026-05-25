<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterKonteksWorkflowV2 extends Migration
{
    public function up()
    {
        /**
         * =========================================================
         * TABLE: konteks
         * Tambah status workflow konteks
         * =========================================================
         */
        $this->forge->addColumn('konteks', [
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => false,
                'default'    => 'draft',
            ],
        ]);

        /**
         * =========================================================
         * TABLE: konteks_proses_bisnis
         * Tambah deskripsi proses contextual
         * =========================================================
         */
        $this->forge->addColumn('konteks_proses_bisnis', [
            'deskripsi_proses' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        /**
         * Rollback tabel konteks
         */
        $this->forge->dropColumn('konteks', 'status');

        /**
         * Rollback tabel konteks_proses_bisnis
         */
        $this->forge->dropColumn('konteks_proses_bisnis', [
            'deskripsi_proses',
            'updated_at',
        ]);
    }
}
