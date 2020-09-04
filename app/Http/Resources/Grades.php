<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Grades extends JsonResource
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
            "study_id"=>$this->study_id,
            "id" => $this->id,
            "exam_date"=> $this->exam_date,
            "quiz_score"=> $this->quiz_score,
            "exam_score"=>$this->exam_score,
            "homework_score"=> $this->homework_score,
            "attendent_score"=> $this->attendent_score,
            "total_score"=> $this->total_score,
        ];
    }
}
