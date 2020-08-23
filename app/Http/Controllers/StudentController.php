<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Student::paginate(5);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'gender' => 'required|',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|',
            'father_name' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'father_position' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'mother_name' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'mother_position' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'address' => 'required|',
            'contact_number' => 'required|min:3|max:30',
        ]);


        if ($validator->passes()) {
            $student = new Student;
            $student->name = $request->name;
            $student->gender = $request->gender;
            $student->date_of_birth = $request->date_of_birth;
            $student->place_of_birth = $request->place_of_birth;
            $student->father_name = $request->father_name;
            $student->father_position = $request->father_position;
            $student->mother_name = $request->mother_name;
            $student->mother_position = $request->mother_position;
            $student->address = $request->address;
            $student->contact_number = $request->contact_number;
            $student->save();
//            $study = new Study();
//            $study->student_id=$student->id;
//            $study->save();
            return response()->json(["error" => "false", "status" => "ok", "data" => $student]);
        }


        return response()->json(['errors' => $validator->errors(), 'success' => 'false']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try
        {
            $student = Student::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Student with id $id is not found "]);
        }
        return response()->json(["data"=>$student,"status"=>"ok"], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $student = Student::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Student with id $id is not found "]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'gender' => 'required|',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|',
            'father_name' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'father_position' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'mother_name' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'mother_position' => 'required|min:3|max:30|regex:/^[a-zA-Z ]+$/u',
            'address' => 'required|',
            'contact_number' => 'required|min:3|max:30',
        ]);

        if ($validator->passes()) {
            foreach($request->all() AS $index => $field){
                $student->$index = $field;
            }
            $is_save = $student->save();
            if($is_save){
                return response()->json(['status'=>'ok','data'=>Student::findOrFail($id),'success'=>'true','message'=>"Record with id $id has been updated"]);
            }
        }


        return response()->json(['errors'=>$validator->errors(),'success'=>'false',"status"=>"failed"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Student with id $id is not found "]);
        }
        $isDelete = $student->delete();
        if ($isDelete) {
            return response()->json(['status' => 'ok', 'message' => $isDelete], 200);
        }
    }
}
