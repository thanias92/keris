<?php

/**
 * =========================================================
 * HELPER: SELERA RISIKO
 * Digunakan untuk:
 * - Menentukan selera risiko berdasarkan nilai risiko
 * - Mapping warna & label selera risiko
 * =========================================================
 */

if (!function_exists('selera_risiko_by_nilai')) {
    /**
     * Ambil data selera risiko berdasarkan nilai risiko
     *
     * @param int   $nilaiRisiko
     * @param array $dataSelera (hasil query selera_risiko)
     * @return array|null
     */
    function selera_risiko_by_nilai(int $nilaiRisiko, array $dataSelera): ?array
    {
        foreach ($dataSelera as $row) {
            if (
                $nilaiRisiko >= $row['nilai_min']
                && $nilaiRisiko <= $row['nilai_max']
            ) {
                return $row;
            }
        }

        return null;
    }
}

if (!function_exists('warna_selera_risiko_class')) {
    /**
     * Mapping warna selera risiko ke class CSS
     *
     * @param string|null $warna
     * @return string
     */
    function warna_selera_risiko_class(?string $warna): string
    {
        return match ($warna) {
            'biru'   => 'bg-blue-200 text-blue-900',
            'hijau'  => 'bg-green-200 text-green-900',
            'kuning' => 'bg-yellow-200 text-yellow-900',
            'oranye' => 'bg-orange-200 text-orange-900',
            'merah'  => 'bg-red-200 text-red-900',
            default  => 'bg-gray-100 text-gray-700',
        };
    }
}

if (!function_exists('label_selera_risiko')) {
    /**
     * Ambil label selera risiko (nama_level)
     *
     * @param array|null $selera
     * @return string
     */
    function label_selera_risiko(?array $selera): string
    {
        return $selera['nama_level'] ?? '-';
    }
}

if (!function_exists('tindakan_selera_risiko')) {
    /**
     * Ambil teks tindakan dari selera risiko
     *
     * @param array|null $selera
     * @return string
     */
    function tindakan_selera_risiko(?array $selera): string
    {
        return $selera['tindakan'] ?? '-';
    }
}

if (!function_exists('hex_warna_selera_risiko')) {
    function hex_warna_selera_risiko(?string $warna): string
    {
        return match ($warna) {
            'biru'   => '#0d6efd',
            'hijau'  => '#198754',
            'kuning' => '#ffc107',
            'oranye' => '#fd7e14',
            'merah'  => '#dc3545',
            default  => '#6c757d',
        };
    }
}
