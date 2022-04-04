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
            'user_id' => $this->user_id,
            'title' => $this->title,
            'comment' => $this->comment,
            'cycle' => $this->cycle,
            // 'archives' => ArchiveResource::collection($this->archives),
            // 'categories' => CategoryResource::collection($this->categories),
        ];
    }
}
