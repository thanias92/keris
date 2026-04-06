<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id'
            ],
        ]);

        // Tambahkan foreign key
        $this->db->query('ALTER TABLE users ADD CONSTRAINT fk_users_roles FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'role_id');
    }
}
