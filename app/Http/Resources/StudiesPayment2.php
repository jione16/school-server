<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ClassesObject as ClassResource;
use App\Http\Resources\SimplePayment;
class StudiesPayment2 extends JsonResource
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
            'student'=>$this->student,
            'class'=> new ClassResource($this->class),
            'payment'=>SimplePayment::collection($this->payment)
        ];
    }
}
