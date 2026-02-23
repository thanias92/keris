<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriRisikoModel extends Model
{
    protected $table      = 'kategori_risiko';
    protected $primaryKey = 'id_kategori_risiko';
    protected $returnType = 'array';
}
