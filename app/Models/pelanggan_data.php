<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pelanggan_data extends Model
{
    use HasFactory;

    protected $table = 'pelanggan_data';
    protected $primaryKey = 'pelanggan_data_id';
    protected $fillable = [
        'pelanggan_data_pelanggan_id',
        'pelanggan_data_jenis',
        'pelanggan_data_file'
    ];

    protected $casts = [
        'pelanggan_data_jenis' => 'string', // Laravel akan membaca enum sebagai string
    ];

    public function pelanggan()
    {
        return $this->hasMany(pelanggan::class, 'pelanggan_id');
    }
}
