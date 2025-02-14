<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'kategori_id'; // "K" harus kapital
    protected $fillable = [
        'kategori_nama'
    ];

    public function alat()
    {
        return $this->hasMany(Alat::class, 'alat_kategori_id'); // hasMany, bukan hasMay
    }
}

