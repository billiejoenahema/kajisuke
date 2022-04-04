<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'housework_id',
        'date',
        'content',
    ];

    /**
     * 紐づく家事を取得する。
     */
    public function housework()
    {
        return $this->belongsTo(Housework::class);
    }
}
