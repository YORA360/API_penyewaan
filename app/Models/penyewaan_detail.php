<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class penyewaan_detail extends Model
{
    use HasFactory;

    protected $table = 'penyewaan_detail';
    protected $primaryKey = 'penyewaan_detail_id';
    protected $fillable = [
        'penyewaan_detail_penyewaan_id',
        'penyewaan_detail_alat_id',
        'penyewaan_detail_jumlah',
        'penyewaan_detail_subHarga'
    ];


    public function penyewaan()
    {
        return $this->belongsTo(penyewaan::class, 'penyewaan_id');
    }

    public function alat()
    {
        return $this->belongsTo(alat::class, 'alat_id');
    }
}
