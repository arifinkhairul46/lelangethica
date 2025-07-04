<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProduk extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'm_image_produk';
    protected $fillable = [
        'produk_id',
        'image_produk',
        'status'
    ];
}
