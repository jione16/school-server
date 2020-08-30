<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Books extends JsonResource
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
            'level'=> $this->level,
            'language'=>$this->language

        ];
    }
}
