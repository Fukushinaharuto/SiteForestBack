<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Square extends Model
{
    protected $fillable = ['id', 'borderRadius'];
    public $incrementing = false; 
}
