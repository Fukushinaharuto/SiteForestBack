<?php

namespace App\Models;
use App\Models\hyperLink;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $fillable = ['id', 'text_color', 'size', 'font', 'children', 'text_align', 'vertical_align'];
    public $incrementing = false;
    public function hyperLink()
    {
        return $this->hasOne(HyperLink::class);
    }
}
