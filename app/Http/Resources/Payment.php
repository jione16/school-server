<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StudiesPayment;
class Payment extends JsonResource
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
            'study' =>  new StudiesPayment($this->study),
            'amount'=> $this->amount,
            'month_pay'=>$this->month_pay,
        ];
    }
}
