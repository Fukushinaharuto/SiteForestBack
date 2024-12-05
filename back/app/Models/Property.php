<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public function pageComponent()
    {
        return belongsTo(PageComponent::class);
    }
}
