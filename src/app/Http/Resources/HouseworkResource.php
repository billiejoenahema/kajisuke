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
            'category_id' => $this->category['id'],
            'cycle_num' => $this->cycle_num,
            'cycle_unit' => $this->cycle_unit,
            'cycle_value' => $this->getCycleValue($this->cycle_num, $this->cycle_unit),
            'next_date' => $this->next_date,
            'archives' => ArchiveResource::collection($this->archives)->sortByDesc('date')->values()->all(),
            'date_diff' => $this->getDateDiff($this->next_date),
        ];
    }

    /**
     * 実行周期を判読可能な文字列に変換して返す。
     *
     * @param  int  $cycle_num
     * @param  int  $cycle_unit
     * @return string
     */
    public static function getCycleValue($cycle_num, $cycle_unit): string
    {
        return  match ($cycle_unit) {
            1 => $cycle_num == 1 ? Housework::DAY['EVERY_DAY'] : $cycle_num . '日に一度',
            2 => $cycle_num == 1 ? Housework::WEEK['EVERY_WEEK'] : $cycle_num . '週に一度',
            3 => $cycle_num == 1 ? Housework::MONTH['EVERY_MONTH'] : $cycle_num . 'ヶ月に一度',
            4 => $cycle_num == 1 ? Housework::YEAR['EVERY_YEAR'] : $cycle_num . '年に一度',
            default => '不明',
        };
    }

    /**
     * 次回実施日までの日数を返す。
     *
     * @param  string  $next_date
     * @return int
     */
    public static function getDateDiff($next_date): int
    {
        $now = new \DateTime();
        $nextDate = new \DateTime($next_date);
        // 今日の日付と次回実施日の差分を数値に変換する
        $diff = (int) $now->diff($nextDate)->format('%R%a');

        return $diff;
    }
}
