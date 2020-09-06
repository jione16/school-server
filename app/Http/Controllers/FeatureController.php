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


    public function getStatEachMonth(){
        $records = array("data"=>[],"status"=>"fails","chart_data"=>[]);
        $year = date("Y");
        for($i=1;$i<=12;$i++){
            $month = str_pad($i, 2, "0", STR_PAD_LEFT);
            $month_name = DateTime::createFromFormat('!m',$i)->format('F');
            $classes = Classes::latest()->whereDate("start_date",'<=',date("Y-m-t", strtotime("$year-$month-01")))->whereDate('end_date','>=',date("Y-m-t", strtotime("$year-$month-01")))->get();
            $count = 0;
            foreach ($classes as $class){
                $studies_count = $class->studies()->count();
                $count+=$studies_count;
            }
            $array = array("month"=>$month,"month_name"=>$month_name,"studies_count"=>$count);
            array_push ($records['chart_data'],$count);
            array_push($records['data'],$array);
            
        }
        $records['status'] = "ok";
        return response()->json($records, 200);
    }

    public function getDashboardCount(){
        $records = array("data"=>[],"status"=>"fails");
        $students_count = DB::table('students')->get()->count();
        $teachers_count = DB::table('staffs')->get()->count();
        $classes_count = DB::table('classes')->get()->count();
        $books_count = DB::table('books')->get()->count();
        return response()->json(["students_count"=>$students_count,"teachers_count"=>$teachers_count,"classes_count"=>$classes_count,"books_count"=>$books_count,"status"=>"ok"],200);
    }

}
