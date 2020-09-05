<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Student;
use App\Http\Resources\ClassesObject as ClassResource;

class StudiesPayment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'student' => new Student($this->student),
            'class'=> new ClassResource($this->class),
        ];
    }
}
