<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateKriteriaKemungkinan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('kriteria_kemungkinan', [
            'nama_level' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'level'
            ],
            'persentase_min' => [
                'type' => 'INT',
                'null' => true
            ],
            'persentase_max' => [
                'type' => 'INT',
                'null' => true
            ],
            'deskripsi_frekuensi' => [
                'type' => 'TEXT',
                'null' => true
            ],
        ]);
    }


    public function down()
    {
        //
    }
}
