<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolePermissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'role_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'permission_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('role_permissions');

        // baru FK
        $this->db->query('ALTER TABLE role_permissions ADD CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE role_permissions ADD CONSTRAINT fk_permission FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('role_permissions');
    }
}
