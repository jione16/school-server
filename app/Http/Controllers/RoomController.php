<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return  Room::paginate(5);
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
            'name' => 'required|min:3|max:50|',
            'remark' => 'nullable|'
        ]);


        if ($validator->passes()) {
            $room = new Room;
            $room->name = $request->name;
            $room->remark = $request->remark;
            $room->save();
			return response()->json(["error"=>"false","status"=>"ok","data"=>$room]);
        }


    	return response()->json(['errors'=>$validator->errors(),'success'=>'false']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $room = Room::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Room with id $id is not found "]);
        }
        return response()->json(["data"=>$room,"status"=>"ok"], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $room = Room::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Room with id $id is not found "]);
        }
        return response()->json(["data"=>$room,"status"=>"ok"], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $room = Room::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Room with id $id is not found "]);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50|',
            'remark' => 'nullable|'
        ]);

        if ($validator->passes()) {
            foreach($request->all() AS $index => $field){
                $room->$index = $field;
            }
            $is_save = $room->save();
            if($is_save){
                return response()->json(['status'=>'ok','data'=>Room::findOrFail($id),'success'=>'true','message'=>"Room with id $id has been updated"]);
            }
        }


    	return response()->json(['errors'=>$validator->errors(),'success'=>'false',"status"=>"failed"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $room = Room::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Room with id $id is not found "]);
        }
        $isDelete = $room->delete();
        if($isDelete){
           return response()->json(['status'=>'ok','message'=>$isDelete], 200);
        }
    }
}
