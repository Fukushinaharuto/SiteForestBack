<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Text;

class HyperLink extends Model
{
    public function text()
    {
        return $this->belongsTo(Text::class);
    }
}
