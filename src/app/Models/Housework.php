<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Housework extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'comment',
        'execute_cycle',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'execute_cycle' => 'datetime',
    ];

    /**
     * 紐づくユーザーを取得する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 紐づくカテゴリを取得する
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * 紐づく履歴を取得する
     */
    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
}
