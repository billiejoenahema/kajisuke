<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    /**
     * 紐づく家事を取得する
     */
    public function housework()
    {
        return $this->belongsTo(Housework::class);
    }
}
