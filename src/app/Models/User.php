<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 所有する家事を取得する。
     */
    public function houseworks()
    {
        return $this->hasMany(Housework::class);
    }

    /**
     * 所有する家事表示順を取得する。
     */
    public function houseworkOrder()
    {
        return $this->hasOne(HouseworkOrder::class);
    }

    /**
     * 所有するカテゴリを取得する。
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
