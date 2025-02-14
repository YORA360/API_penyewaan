<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'pelanggan_id';
    protected $fillable = [
        'pelanggan_nama',
        'pelanggan_alamat',
        'pelanggan_noTelp',
        'pelanggan_email'
    ];


    public function pelanggan_data()
    {
        return $this->hasOne(pelanggan_data::class, 'pelanggan_data_pelanggan_id');
    }

}
