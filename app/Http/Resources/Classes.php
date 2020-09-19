<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Classes extends JsonResource
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
            'staff_id' => $this->staff_id,
            'book_id'=> $this->book_id,
            'room_id'=>$this->room_id,
            'study_time' => $this->study_time,
            'start_date'=> $this->start_date,
            'end_date'=>$this->end_date,
            'price'=>$this->price
        ];
    }

}
