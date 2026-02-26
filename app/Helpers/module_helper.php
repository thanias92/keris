<?php

if (!function_exists('pk_module_config')) {

    function pk_module_config(string $menu, string $activeTab): ?array
    {
        $map = [

            'penetapan_konteks' => [

                'konteks' => [
                    'label'     => 'Konteks',
                    'module'    => 'konteks',
                    'routeBase' => 'penetapan-konteks/konteks'
                ],

                'proses_bisnis' => [
                    'label'     => 'Proses',
                    'module'    => 'proses_bisnis',
                    'routeBase' => 'penetapan-konteks/proses-bisnis'
                ],

                'sasaran_kinerja' => [
                    'label'     => 'Sasaran',
                    'module'    => 'sasaran_kinerja',
                    'routeBase' => 'penetapan-konteks/sasaran-kinerja'
                ],

                'pemangku_kepentingan' => [
                    'label'     => 'Pemangku',
                    'module'    => 'pemangku_kepentingan',
                    'routeBase' => 'penetapan-konteks/pemangku'
                ],

                'peraturan_terkait' => [
                    'label'     => 'Peraturan',
                    'module'    => 'peraturan_terkait',
                    'routeBase' => 'penetapan-konteks/peraturan'
                ],

            ],

        ];

        return $map[$menu][$activeTab] ?? null;
    }
}
