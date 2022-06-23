<?php

namespace App\Http\Resources;

use App\Models\Housework;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'comment' => $this->comment,
            'category' => new CategoryResource($this->category),
            'cycle_num' => $this->cycle_num,
            'cycle_unit' => $this->cycle_unit,
            'cycle_value' => self::getCycleValue($this->cycle_num, $this->cycle_unit),
            'next_date' => $this->next_date,
            'archives' => ArchiveResource::collection($this->archives),
            'is_over_date' => self::isOverDate($this->next_date),
        ];
    }

    /**
     * 実行周期を判読可能な文字列に変換して返す。
     *
     * @param int $cycle_num
     * @param int $cycle_unit
     * @return string
     */
    public static function getCycleValue($cycle_num, $cycle_unit): string
    {
        switch ($cycle_unit) {
            case 1:
                return $cycle_num == 1 ? Housework::DAY['EVERY_DAY'] : $cycle_num . '日に一度';
            case 2:
                return $cycle_num == 1 ? Housework::WEEK['EVERY_WEEK'] : $cycle_num . '週に一度';
            case 3:
                return $cycle_num == 1 ? Housework::MONTH['EVERY_MONTH'] : $cycle_num . 'ヶ月に一度';
            case 4:
                return $cycle_num == 1 ? Housework::YEAR['EVERY_YEAR'] : $cycle_num . '年に一度';
            default:
                return '不明';
        }
    }

    /**
     * 次回実施日が過ぎているかどうかを返す。
     *
     * @param string $next_date
     * @return bool
     */
    public static function isOverDate($next_date): bool
    {
        $now = new \DateTime();
        $next_date = new \DateTime($next_date);
        return $now > $next_date;
    }

}
