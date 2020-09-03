<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try
        {
            $grade = Grade::where('study_id', '=',$request->study_id)->firstOrFail();
            return
            self::update($request,$grade->id);
       }
       catch(ModelNotFoundException $e)
       {
           $validator = Validator::make($request->all(), [
               'study_id' => 'required|Numeric',
               'exam_date'=>'required|date',
               'quiz_score' => 'required|Numeric|min:0|max:20',
               'exam_score' => 'required|Numeric|min:0|max:50',
               'homework_score'=>'required|Numeric|min:0|max:20',
               'attendent_score' => 'required|Numeric|min:0|max:10'

           ]);


           if ($validator->passes()) {
               $grade = new Grade;
               $grade->study_id = $request->study_id;
               $grade->exam_date = $request->exam_date;
               $grade->quiz_score = $request->quiz_score;
               $grade->exam_score = $request->exam_score;
               $grade->homework_score = $request->homework_score;
               $grade->attendent_score = $request->attendent_score;
               $grade->total_score = $request->quiz_score + $request->exam_score + $request->homework_score + $request->attendent_score;
               $grade->save();
               return response()->json(["error"=>"false","message"=>"Successfully inserted score","status"=>"ok","data"=>$grade]);
           }


           return response()->json(['errors'=>$validator->errors(),'success'=>'false']);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
         {
             $grade = Grade::findOrFail($id);
         }
         catch(ModelNotFoundException $e)
         {
             return response()->json(['status' => 'failed', 'data' => null, 'message' => "grade with id $id is not found "]);
         }
         return response()->json(["data"=>$grade,"status"=>"ok"], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $grade = Grade::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "grade with id $id is not found "]);
        }
        return response()->json(["data"=>$grade,"status"=>"ok"], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $grade = Grade::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "grade with id $id is not found "]);
        }


        $validator = Validator::make($request->all(), [
            'study_id' => 'required|Numeric',
            'exam_date'=>'required|date',
            'quiz_score' => 'required|Numeric|min:0|max:20',
            'exam_score' => 'required|Numeric|min:0|max:50',
            'homework_score'=>'required|Numeric|min:0|max:20',
            'attendent_score' => 'required|Numeric|min:0|max:10'

        ]);

        if ($validator->passes()) {
            foreach($request->all() AS $index => $field){
                $grade->$index = $field;
            }
            $grade->total_score = $request->quiz_score + $request->exam_score + $request->homework_score + $request->attendent_score;
            $is_save = $grade->save();
            if($is_save){
                return response()->json(['status'=>'ok','data'=>Grade::findOrFail($id),'success'=>'true','message'=>"grade with id $id has been updated"]);
            }
        }


        return response()->json(['errors'=>$validator->errors(),'success'=>'false',"status"=>"failed"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
         {
             $grade = Grade::findOrFail($id);
         }
         catch(ModelNotFoundException $e)
         {
             return response()->json(['status' => 'failed', 'data' => null, 'message' => "grade with id $id is not found "]);
         }
         $isDelete = $grade->delete();
         if($isDelete){
            return response()->json(['status'=>'ok','message'=>$isDelete], 200);
         }
    }
}
