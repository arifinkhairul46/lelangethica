<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'm_produk';
     protected $fillable = [
        'nama_produk',
        'stok',
        'brand_id',
        'sarimbit_id',
        'harga',
        'diskon',
        'image_produk',
        'hpp',
        'status',
        'datetime_released',
        'datetime_end'
    ];
}
