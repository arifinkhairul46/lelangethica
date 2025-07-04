<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLelang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 't_order_lelang';
    protected $fillable = [
        'user_id',
        'produk_id',
        'no_order',
        'qty'
    ];
}
