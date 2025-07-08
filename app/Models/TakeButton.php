<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeButton extends Model
{
    use HasFactory;
     protected $primaryKey = 'id';
    protected $table = 'm_take_button';
    protected $fillable = [
       'name',
       'value',
       'label'
    ];
}
