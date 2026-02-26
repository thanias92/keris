<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKonteksPemangku extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_konteks_pemangku' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_konteks' => [
                'type' => 'INT',
            ],
            'id_pemangku' => [
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey('id_konteks_pemangku', true);

        $this->forge->addForeignKey(
            'id_konteks',
            'konteks',
            'id_konteks',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'id_pemangku',
            'pemangku_kepentingan',
            'id_pemangku',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('konteks_pemangku');
    }

    public function down()
    {
        $this->forge->dropTable('konteks_pemangku');
    }
}
