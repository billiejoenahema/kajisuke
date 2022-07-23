<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'gender',
        'birth',
        'tel',
        'zipcode',
        'prefecture',
        'city',
        'street_address',
    ];

    /**
     * 紐づくユーザーを取得する。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
