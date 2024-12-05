<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = [
        'type',
    ];

    public function pageComponents() 
    {
        return hasMany(pageComponent::class);
    }
}
