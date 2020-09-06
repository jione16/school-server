<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\Payment as PaymentResource;
use Validator;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::paginate(5);
        return PaymentResource::collection($payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'study_id' => 'required|Integer',
            'amount' => 'required|numeric',
            'month_pay' => 'required|numeric',
            'staff_id' => 'Integer',
        ]);


        if ($validator->passes()) {
            $payment = new Payment;
            $payment->study_id = $request->study_id;
            $payment->amount = $request->amount;
            $payment->month_pay = $request->month_pay;
            $payment->staff_id = 1;
            $payment->save();
			return response()->json(["error"=>"false","status"=>"ok","data"=>$payment]);
        }


    	return response()->json(['errors'=>$validator->errors(),'success'=>'false']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
         {
             $payment = Payment::findOrFail($id);
         }
         catch(ModelNotFoundException $e)
         {
             return response()->json(['status' => 'failed', 'data' => null, 'message' => "Payment with id $id is not found"]);
         }
         $isDelete = $payment->delete();
         if($isDelete){
            return response()->json(['status'=>'ok','message'=>$isDelete], 200);
         }
    }
}
