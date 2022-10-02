<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Profile
 *
 * @property int $id
 * @property int $user_id ユーザーID
 * @property string|null $last_name 姓
 * @property string|null $first_name 名
 * @property string $gender 性別
 * @property string|null $birth 生年月日
 * @property string|null $tel 電話番号
 * @property string|null $zipcode1 郵便番号1
 * @property string|null $zipcode2 郵便番号2
 * @property string|null $prefecture 都道府県
 * @property string|null $city 市町村
 * @property string|null $street_address 町丁目以下
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ProfileFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile wherePrefecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereZipcode1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereZipcode2($value)
 * @mixin \Eloquent
 * @property string|null $image プロフィール画像
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereImage($value)
 */
class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image',
        'last_name',
        'first_name',
        'gender',
        'birth',
        'tel',
        'zipcode1',
        'zipcode2',
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
