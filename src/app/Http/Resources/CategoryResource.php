<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        /** @var \App\Models\Category $this */
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'houseworks' => collect($this->houseworks)->pluck('title'),
        ];
    }
}
