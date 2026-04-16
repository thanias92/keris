<?php

use App\Models\PenugasanPengelolaModel;

function getActivePenugasan()
{
    $userId = session('user_id');
    if (!$userId) return null;

    $model = new PenugasanPengelolaModel();

    return $model
        ->where('pengelola_id', $userId)
        ->orderBy('tahun', 'desc')
        ->first();
}
