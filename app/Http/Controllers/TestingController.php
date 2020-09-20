<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf;
use DateTime;
use App\Classes;
class TestingController extends Controller
{
    //

    public function Test2(){
        return "work";
    }
    public function Test(){
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
        $pdf = App::make('snappy.pdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('report.test',['data'=>$records]);
        return $pdf->inline();
    }
}
