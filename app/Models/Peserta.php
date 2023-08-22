<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'nama_lengkap',
        'usia',
        'jenis_kelamin',
        'asal_kota'
    ];

    public function kategorikelas()
    {
        return $this->hasMany('KategoriKelas::class','id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id_user')
    }
}
