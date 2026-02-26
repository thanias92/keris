<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKonteksPeraturan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_konteks_peraturan' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_konteks' => [
                'type' => 'INT',
            ],
            'id_peraturan' => [
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey('id_konteks_peraturan', true);

        $this->forge->addForeignKey(
            'id_konteks',
            'konteks',
            'id_konteks',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'id_peraturan',
            'peraturan_terkait',
            'id_peraturan',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('konteks_peraturan');
    }

    public function down()
    {
        $this->forge->dropTable('konteks_peraturan');
    }
}
