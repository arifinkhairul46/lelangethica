<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeOptionProduk extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'm_take_option_produk';
    protected $fillable = [
        'produk_id',
        'take_btn_id',
        'status'
    ];

    public function button()
{
    return $this->belongsTo(TakeButton::class, 'take_btn_id');
}
}
