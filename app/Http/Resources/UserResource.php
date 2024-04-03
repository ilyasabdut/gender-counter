<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $name = json_decode($this->name)->title . '. '. json_decode($this->name)->first . ' ' . json_decode($this->name)->last;
        $street = json_decode($this->location)->street->name . ', ' . json_decode($this->location)->street->number;
        $city = json_decode($this->location)->city;
        $state = json_decode($this->location)->state;
        $country = json_decode($this->location)->country;
        $postcode = json_decode($this->location)->postcode;
        $location = $street . ', ' . $city . ', ' . $state . ', ' . $country . ', ' . $postcode;

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $name,
            'age' => $this->age,
            'gender' => $this->gender,
            'location' => $location
        ];
    }
}
