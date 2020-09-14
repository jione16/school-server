<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Study;
use App\Student;
use App\Http\Resources\StudiesObject;
use App\Http\Resources\Studies as StudiesResource;
use App\Http\Resources\StudiesPayment2;
use App\Classes;
use App\Http\Resources\StudiesGradeResource;

class StudyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getStudiesByClass($class_id){
        $studies = Study::where('class_id',$class_id)->paginate(5);
        return StudiesGradeResource::collection($studies);
    }
    public function getStudies($student_id){

        try
        {
            $student = Student::findOrFail($student_id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Student record with id $id is not found "]);
        }
        $studies = Study::where('student_id',$student_id)->get();

        return response()->json(["error"=>false,"status"=>"ok","student"=>["id"=>$student->id],"studies"=>StudiesObject::collection($studies)]);
    }
    public function getStudiesPayments($student_id){

        try
        {
            $student = Student::findOrFail($student_id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Student record with id $id is not found "]);
        }
        $studies = Study::where('student_id',$student_id)->get();

        return response()->json(["error"=>false,"status"=>"ok","student"=>["id"=>$student->id],"studies"=>StudiesPayment2::collection($studies)]);
    }
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
        $student_id = $request->student_id;
        $class_id = $request->class_id;
        $now = date('Y-m-d');
        //get student's studies
        $studies = Study::where('student_id',$student_id)->get();
        //register class
        try
        {
            $registerClass = Classes::findOrFail($class_id);
            if($registerClass->end_date<= $now){
                return response()->json(['err'=>true,'message'=>'Invalid period time','class'=>$registerClass]);
            }
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['err'=>true,'status' => 'failed', 'data' => null, 'message' => "Class with id $id is not found "]);
        }
        //get class object
        $studiesObject = StudiesResource::collection($studies);
        //active class array
        $activeClassArr = array();
        foreach($studiesObject as $study){
            // if($study->class->start_date <= $now && $study->class->end_date >= $now){
            if($study->class->end_date >= $now){
                array_push($activeClassArr,$study->class);
            }
        }

        //validation
        foreach($activeClassArr as $activeClass){
            if($activeClass->study_time==$registerClass->study_time){
                if($registerClass->start_date <= $activeClass->end_date){
                    return response()->json(['err'=>true,'message'=>'Time duplicate','reg_class'=>$registerClass,'dup_class'=>$activeClass]);
                }
            }
        }

        $study = new Study;
        $study->student_id = $student_id;
        $study->class_id = $class_id;
        $isSave = $study->save();

        if($isSave){
            return response()->json(['message'=>'success','err'=>false,'activeClass'=>$activeClassArr]);
        }else{
            return response()->json(['message'=>'something went wrong','err'=>true]);
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
        $study = Study::findOrFail($id);

        return new StudiesPayment2($study);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
            $study = Study::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Study with id $id is not found "]);
        }
        $isDelete = $study->delete();
        if($isDelete){
           return response()->json(['status'=>'ok','message'=>$isDelete], 200);
        }
    }
}
