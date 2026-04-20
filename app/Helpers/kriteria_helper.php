<?php

function formatPersentaseKemungkinan(array $row): string
{
    if ($row['level'] == 1) {
        return 'x ≤ ' . $row['persentase_max'] . '%';
    }

    if ($row['level'] == 5) {
        return 'x > ' . $row['persentase_min'] . '%';
    }

    return $row['persentase_min'] . '% < x ≤ ' . $row['persentase_max'] . '%';
}
function warna_risiko_class(?string $warna): string
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