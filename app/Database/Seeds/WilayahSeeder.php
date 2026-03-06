<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // PROVINSI
            [
                'kode_wilayah' => '14',
                'nama_wilayah' => 'Provinsi Riau',
                'tipe'         => 'provinsi',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            // KABUPATEN
            ['kode_wilayah' => '1401', 'nama_wilayah' => 'Kab. Kuantan Singingi', 'tipe' => 'kabupaten'],
            ['kode_wilayah' => '1402', 'nama_wilayah' => 'Kab. Indragiri Hulu', 'tipe' => 'kabupaten'],
            ['kode_wilayah' => '1403', 'nama_wilayah' => 'Kab. Indragiri Hilir', 'tipe' => 'kabupaten'],
            ['kode_wilayah' => '1404', 'nama_wilayah' => 'Kab. Pelalawan', 'tipe' => 'kabupaten'],
            ['kode_wilayah' => '1405', 'nama_wilayah' => 'Kab. Siak', 'tipe' => 'kabupaten'],
            ['kode_wilayah' => '1406', 'nama_wilayah' => 'Kab. Kampar', 'tipe' => 'kabupaten'],
            ['kode_wilayah' => '1407', 'nama_wilayah' => 'Kab. Rokan Hulu', 'tipe' => 'kabupaten'],
            ['kode_wilayah' => '1408', 'nama_wilayah' => 'Kab. Bengkalis', 'tipe' => 'kabupaten'],
            ['kode_wilayah' => '1409', 'nama_wilayah' => 'Kab. Rokan Hilir', 'tipe' => 'kabupaten'],
            ['kode_wilayah' => '1410', 'nama_wilayah' => 'Kab. Kepulauan Meranti', 'tipe' => 'kabupaten'],

            // KOTA
            ['kode_wilayah' => '1471', 'nama_wilayah' => 'Kota Pekanbaru', 'tipe' => 'kota'],
            ['kode_wilayah' => '1473', 'nama_wilayah' => 'Kota Dumai', 'tipe' => 'kota'],
        ];

        foreach ($data as &$row) {
            $row['created_at'] = date('Y-m-d H:i:s');
            $row['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db->table('wilayah')->insertBatch($data);
    }
}
