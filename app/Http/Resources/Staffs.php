<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Staffs extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'contact_number' => $this->contact_number,
            'address' => $this->address
        ];
    }
}
