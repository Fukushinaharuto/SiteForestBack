<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name',
        'route',
    ];

    public function project()
    {
        return belongsTo(Project::class);
    }

    public function pageComponents()
    {
        return hasMany(pageComponent::class);
    }
}
