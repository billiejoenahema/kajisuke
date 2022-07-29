<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'user_id' => $this->user_id,
            'last_name' => $this->last_name ?? '',
            'first_name' => $this->first_name ?? '',
            'gender' => $this->gender,
            'birth' => $this->birth ?? '',
            'tel' => $this->tel ?? '',
            'zipcode1' => $this->zipcode1 ?? '',
            'zipcode2' => $this->zipcode2 ?? '',
            'prefecture' => $this->prefecture ?? '',
            'city' => $this->city ?? '',
            'street_address' => $this->street_address ?? '',
        ];
    }
}
