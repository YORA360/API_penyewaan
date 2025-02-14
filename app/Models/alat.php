<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class alat extends Model
{
    use HasFactory;

    protected $table = 'alat';
    protected $primaryKey = 'alat_id';
    protected $fillable = [
        'alat_nama',
        'alat_deskripsi',
        'alat_hargaPerhari',
        'alat_stok',
        'alat_kategori_id'
    ];


    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_id');
    }

    public function penyewaan_detail()
    {
        return $this->hasMany(penyewaan_detail::class, 'penyewaan_detail_penyewaan_id');
    }

}
