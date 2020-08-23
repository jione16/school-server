<?php

namespace App\Http\Controllers;

use App\Staff;
use Illuminate\Http\Request;
use Validator;
class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Staff::paginate(5);
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
            'name' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'gender' => 'required|',
            'nationality' => 'required|',
            'foreign_language_level' => 'required|',
            'genaral_knowledge_level' => 'required|',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|',
            'address' => 'required|',
            'contact_number' => 'required|min:3|max:30',
            'remark'=>'nullable|'
        ]);


        if ($validator->passes()) {
            $staff = new Staff;
            $staff->name = $request->name;
            $staff->gender = $request->gender;
            $staff->nationality = $request->nationality;
            $staff->foreign_language_level = $request->foreign_language_level;
            $staff->genaral_knowledge_level = $request->genaral_knowledge_level;
            $staff->date_of_birth = $request->date_of_birth;
            $staff->place_of_birth = $request->place_of_birth;
            $staff->address = $request->address;
            $staff->contact_number = $request->contact_number;
            $staff->remark=$request->remark;
            $staff->save();
            return response()->json(["error"=>"false","status"=>"ok","data"=>$staff]);
        }


        return response()->json(['errors'=>$validator->errors(),'success'=>'false']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $staff = Staff::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "staff with id $id is not found "]);
        }
        return response()->json(["data"=>$staff,"status"=>"ok"], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $staff = Staff::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "staff with id $id is not found "]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'gender' => 'required|',
            'nationality' => 'required|',
            'foreign_language_level' => 'required|',
            'genaral_knowledge_level' => 'required|',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|',
            'address' => 'required|',
            'contact_number' => 'required|min:3|max:30',
            'remark'=>'nullable|'
        ]);


        if ($validator->passes()) {
            foreach($request->all() AS $index => $field){
                $staff->$index = $field;
            }
            $is_save = $staff->save();
            if($is_save){
                return response()->json(['status'=>'ok','data'=>Staff::findOrFail($id),'success'=>'true','message'=>"Record with id $id has been updated"]);
            }
        }


        return response()->json(['errors'=>$validator->errors(),'success'=>'false',"status"=>"failed"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $staff = Staff::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Staff with id $id is not found "]);
        }
        $isDelete = $staff->delete();
        if($isDelete){
            return response()->json(['status'=>'ok','message'=>$isDelete], 200);
        }
    }
}
