<?php

namespace App\Http\Resources;

use App\Services\HouseworkService;
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
        $array = explode(' ', $this->cycle);
        $cycle = [
            'num' => $array[0],
            'unit' => $array[1],
        ];

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'comment' => $this->comment,
            'cycle' => $cycle,
            // 'archives' => ArchiveResource::collection($this->archives),
            'categories' => CategoryResource::collection($this->categories),
            'next_date' => HouseworkService::getNextDate($this->cycle, $this->updated_at),
        ];
    }
}
