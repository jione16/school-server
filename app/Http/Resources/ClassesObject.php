<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Staffs as StaffResource;
use App\Http\Resources\Books as BookResource;
use App\Http\Resources\Rooms as RoomResource;

class ClassesObject extends JsonResource
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
            'staff' => new StaffResource($this->staff),
            'book'=> new BookResource($this->book),
            'room'=>new RoomResource($this->room),
            'study_time' => $this->study_time,
            'start_date'=> $this->start_date,
            'end_date'=>$this->end_date
        ];
    }
}
