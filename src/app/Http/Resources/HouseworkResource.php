<?php

namespace App\Http\Resources;

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
            'next_date' => $this->next_date,
            'archives' => ArchiveResource::collection($this->archives),
        ];
    }
}
