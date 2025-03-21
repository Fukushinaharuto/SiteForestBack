<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'device',
    ];
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
