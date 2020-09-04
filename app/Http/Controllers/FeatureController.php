<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;
use App\Classes;
use App\Http\Resources\ClassesObject;
class FeatureController extends Controller
{
    public function newStudentsEachMonth(){
        $records = array("data"=>[]);
        for($i=1;$i<=12;$i++){
            $month_name = DateTime::createFromFormat('!m',$i)->format('F');
            $students_count = DB::table('books')->whereMonth('created_at',"$i")->get()->count();
            $array = array("month"=>$i,"month_name"=>$month_name,"count"=>$students_count);
            array_push($records['data'],$array);
        }

        return response()->json($records, 200);

    }


    public function getMyClasses($teacher_id){
        
        $classes = Classes::where('staff_id',$teacher_id)->paginate(5);
        return ClassesObject::collection($classes);
    }

}
