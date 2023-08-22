<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKelas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_peserta',
        'jenis_kategori_kelas'
    ];
}
