<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdTimToUsers extends Migration
{
    public function up()
    {
        // 1. Tambah kolom id_tim
        $this->forge->addColumn('users', [
            'id_tim' => [
                'type'       => 'INT',
                'null'       => true,
                'after'      => 'role_id', // opsional, biar rapi
            ],
        ]);

        // 2. Tambah foreign key ke tim_kerja
        $this->db->query("
            ALTER TABLE users
            ADD CONSTRAINT fk_users_tim
            FOREIGN KEY (id_tim)
            REFERENCES tim_kerja(id_tim)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ");
    }

    public function down()
    {
        // 1. Drop foreign key dulu
        $this->db->query("
            ALTER TABLE users
            DROP CONSTRAINT IF EXISTS fk_users_tim
        ");

        // 2. Drop kolom
        $this->forge->dropColumn('users', 'id_tim');
    }
}
