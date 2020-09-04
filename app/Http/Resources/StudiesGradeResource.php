<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Student;
use App\Http\Resources\Grades;
class StudiesGradeResource extends JsonResource
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
            'student' => new Student($this->student),
            'grade'=> Grades::collection($this->grade)
        ];
    }
}
