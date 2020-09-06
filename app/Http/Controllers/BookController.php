<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Validator;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::paginate(5);
    }

    public function search(Request $request){
        return Book::where('name','like','%'.$request->query('name').'%')->paginate(5)->appends(request()->query());
        
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
         $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50|',
            'level' => 'required|min:1|max:50|',
            'language'=>'required|min:3|max:50|'

        ]);


        if ($validator->passes()) {
            $book = new Book;
            $book->name = $request->name;
            $book->level = $request->level;
            $book->language = $request->language;
            $book->save();
			return response()->json(["error"=>"false","status"=>"ok","data"=>$book]);
        }


    	return response()->json(['errors'=>$validator->errors(),'success'=>'false']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $book = Book::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Book with id $id is not found "]);
        }
        return response()->json(["data"=>$book,"status"=>"ok"], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try
        {
            $book = Book::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => "Book with id $id is not found "]);
        }


        $validator = Validator::make($request->all(), [
          'name' => 'required|min:3|max:50|',
          'level' => 'required|min:1|max:50|',
          'language'=>'required|min:3|max:50|'
        ]);

        if ($validator->passes()) {
            foreach($request->all() AS $index => $field){
                $book->$index = $field;
            }
            $is_save = $book->save();
            if($is_save){
                return response()->json(['status'=>'ok','data'=>Book::findOrFail($id),'success'=>'true','message'=>"Book with id $id has been updated"]);
            }
        }


        return response()->json(['errors'=>$validator->errors(),'success'=>'false',"status"=>"failed"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
         {
             $book = Book::findOrFail($id);
         }
         catch(ModelNotFoundException $e)
         {
             return response()->json(['status' => 'failed', 'data' => null, 'message' => "Book with id $id is not found "]);
         }
         $isDelete = $book->delete();
         if($isDelete){
            return response()->json(['status'=>'ok','message'=>$isDelete], 200);
         }
    }
}
