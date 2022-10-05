<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Archive
 *
 * @property int $id
 * @property int $housework_id 家事ID
 * @property string $date 実施日
 * @property string $content 実施内容
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Housework|null $housework
 * @method static \Database\Factories\ArchiveFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Archive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Archive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Archive query()
 * @method static \Illuminate\Database\Eloquent\Builder|Archive whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archive whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archive whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archive whereHouseworkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Archive whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Archive extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     *
     * @var array<string>
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
