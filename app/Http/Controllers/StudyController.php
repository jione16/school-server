<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Study;
use App\Student;
use App\Http\Resources\StudiesObject;
class StudyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
