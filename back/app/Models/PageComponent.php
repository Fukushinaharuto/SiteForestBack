<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageComponent extends Model
{
    protected $fillable = [
        'page_id', 'type', 'top', 'left', 'width', 'height', 'color', 'unit', 'border', 'border_color', 'opacity', 'angle',
    ];

    public function square()
    {
        return $this->hasOne(Square::class);
    }

    public function text()
    {
        return $this->hasOne(Text::class);
    }
    public function page()
    {
        return belongsTo(Page::class);
    }
}
