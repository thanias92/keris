<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeraturanDefaultFixSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('peraturan_terkait')
            ->whereNotIn('id_peraturan', [1, 2, 3])
            ->update(['is_default' => false]);
    }
}
