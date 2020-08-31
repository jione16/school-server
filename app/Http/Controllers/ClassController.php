<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Room;
use App\Staff;
use App\Book;
use App\Http\Resources\Classes as classResource;
use App\Http\Resources\ClassesObject as classResourceObject;
use Illuminate\Http\Request;
use Validator;
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function objAll(){
        $classes = Classes::paginate(5);
        return classResourceObject::collection($classes);
    }

    public function getRegisterData(){
        $rooms = Room::all();
        $teachers = Staff::all();
        $books = Book::all();

        $rooms_array = array();
        $teachers_array = array();
        $books_array = array();
        $study_time_array = array(
            ["value"=>1,"name" =>"Morning | 7:30-10:30"],
            ["value"=>2,"name" =>"Afternoon | 1:30-4:30"],
            ["value"=>3,"name" =>"Evening 5:30 | 6:30"]
        );
        foreach ($rooms as $room){
            $x["value"] = $room['id'];
            $x["name"] = $room['name'];
            array_push($rooms_array,$x);
        }
        foreach ($teachers as $teacher){
            $x["value"] = $teacher['id'];
            $x["name"] = $teacher['name'];
            array_push($teachers_array,$x);
        }
        foreach ($books as $book){
            $x["value"] = $book['id'];
            $x["name"] = $book['name'];
            array_push($books_array,$x);
        }

        return response()->json(["rooms"=>$rooms_array,"teachers"=>$teachers_array,"books"=>$books_array,"times"=>$study_time_array]);
    }
    public function index()
    {
        $classes = ClassResource::collection(Classes::all()->sortByDesc('id'));
        return response()->json(["data"=>$classes,"status"=>"ok",], 200);
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
            'staff_id' => 'required|Integer',
            'book_id' => 'required|Integer',
            'room_id' => 'required|Integer',
            'study_time' => 'required|',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);


        if ($validator->passes()) {
            $classes = new Classes;
            $classes->staff_id = $request->staff_id;
            $classes->book_id = $request->book_id;
            $classes->room_id = $request->room_id;
            $classes->study_time = $request->study_time;
            $classes->start_date = $request->start_date;
            $classes->end_date = $request->end_date;
            $classes->save();
            return response()->json(["error"=>"false","status"=>"ok","data"=>$classes]);
        }


        return response()->json(['errors'=>$validator->errors(),'success'=>'false']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $study_time_array = array(
                ["value"=>1,"name" =>"Morning | 7:30-10:30"],
                ["value"=>2,"name" =>"Afternoon | 1:30-4:30"],
                ["value"=>3,"name" =>"Evening 5:30 | 6:30"]
            );
            $class = Classes::findOrFail($id);
            $teacher  = Staff::findOrFail($class->staff_id);
            $room  = Room::findOrFail($class->room_id);
            $book = Book::findOrFail($class->book_id);
            
            $r["value"] = $room['id'];
            $r["name"] = $room['name'];
            $t["value"] = $teacher['id'];
            $t["name"] = $teacher['name'];
            $b["value"] = $book['id'];
            $b["name"] = $book['name'];
            
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Class with id $id is not found "]);
        }
        return response()->json(["data"=>[
        'id'=>$id,
        'teacher'=>$t,
        'room'=>$r,
        'book'=>$b,
        'start_date'=>$class->start_date,
        'time'=>$study_time_array[intval($class->study_time)-1],
        'end_date'=>$class->end_date
        ],"status"=>"ok"], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $class = Classes::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Class with id $id is not found "]);
        }

        $validator = Validator::make($request->all(), [
            'staff_id' => 'required|Integer',
            'book_id' => 'required|Integer',
            'room_id' => 'required|Integer',
            'study_time' => 'required|',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        if ($validator->passes()) {
            foreach($request->all() AS $index => $field){
                $class->$index = $field;
            }
            $is_save = $class->save();
            if($is_save){
                return response()->json(['status'=>'ok','data'=>Classes::findOrFail($id),'success'=>'true','message'=>"Class with id $id has been updated"]);
            }
        }

        return response()->json(['errors'=>$validator->errors(),'success'=>'false',"status"=>"failed"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
         {
             $class = Classes::findOrFail($id);
         }
         catch(ModelNotFoundException $e)
         {
             return response()->json(['status' => 'failed', 'data' => null, 'message' => "Class with id $id is not found "]);
         }
         $isDelete = $class->delete();
         if($isDelete){
            return response()->json(['status'=>'ok','message'=>$isDelete], 200);
         }
    }
}
