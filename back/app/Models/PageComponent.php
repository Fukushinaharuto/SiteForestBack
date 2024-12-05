<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageComponent extends Model
{
    protected $fillable = [
        'top',
        'left',
        'width',
        'height',
    ];
    public function page()
    {
        return belongsTo(Page::class);
    }

    public function component()
    {
        return belongsTo(Component::class);
    }

    public function properties()
    {
        return hasMany(Property::class);
    }
}
