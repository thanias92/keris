<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPengelolaIdToUsers extends Migration
{
    public function up()
    {
        // Tambah kolom pengelola_id
        $this->forge->addColumn('users', [
            'pengelola_id' => [
                'type'       => 'INT',
                'null'       => true,
            ],
        ]);

        // (Optional tapi recommended) foreign key
        $this->db->query('
            ALTER TABLE users
            ADD CONSTRAINT fk_users_pengelola
            FOREIGN KEY (pengelola_id)
            REFERENCES pengelola_risiko(id)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        // Drop foreign key dulu
        $this->db->query('
            ALTER TABLE users
            DROP CONSTRAINT IF EXISTS fk_users_pengelola
        ');

        // Drop kolom
        $this->forge->dropColumn('users', 'pengelola_id');
    }
}
