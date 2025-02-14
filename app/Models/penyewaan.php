<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class penyewaan extends Model
{
    use HasFactory;

    protected $table = 'penyewaan';
    protected $primaryKey = 'penyewaan_id';
    protected $fillable = [
        'penyewaan_pelanggan_id',
        'penyewaan_tglSewa',
        'penyewaan_tglKembali',
        'status_Pembayaran',
        'status_Pengembalian',
        'penyewaan_totalHarga'
    ];


    protected $casts = [
        'status_Pembayaran' => 'string', 
        'status_Pengembalian' => 'string'// Laravel akan membaca enum sebagai string
    ];


    public function penyewaan()
    {
        return $this->belongsTo(penyewaan::class, 'penyewaan_id');
    }

    public function penyewaan_detail()
    {
        return $this->hasMany(penyewaan_detail::class, 'penyewaan_detail_penyewaan_id');
    }

    public function pelanggan()
    {
        return $this->belognsTo(pelanggan::class,'pelanggan_id');
    }
}
