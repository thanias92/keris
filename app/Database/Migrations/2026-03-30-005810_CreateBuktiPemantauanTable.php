<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBuktiPemantauanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bukti' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_pemantauan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => 'now()',
            ],
        ]);

        $this->forge->addKey('id_bukti', true); // PRIMARY KEY

        $this->forge->createTable('bukti_pemantauan');

        // Foreign key menggunakan raw query untuk kompatibilitas PostgreSQL
        $this->db->query('
            ALTER TABLE bukti_pemantauan
            ADD CONSTRAINT fk_bukti_pemantauan
            FOREIGN KEY (id_pemantauan)
            REFERENCES pemantauan_risiko(id_pemantauan)
            ON DELETE CASCADE
        ');
    }

    public function down()
    {
        $this->forge->dropTable('bukti_pemantauan', true);
    }
}
