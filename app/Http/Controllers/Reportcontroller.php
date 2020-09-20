<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use App\Book;
use App\Study;
use App\Payment;
use PdfReport;
use DB;
use App\Classes;
use Exception;
use Carbon\Carbon;
use DateTime;
class Reportcontroller extends Controller
{
    //
    public function test(Request $request)
    {
        $books = new Book;
        return response()->json(['data' => $books->get()]);
    }




    public function payment($payment_id){
            $title = 'Payment detail'; // Report title

            $payment = Payment::findOrFail($payment_id);
            $queryBuilder = Payment::where('id',$payment_id);
            $meta = [ // For displaying filters description on header
                'No.' => $payment->id,
                'Student name' => $payment->study->student->name,
                'receiver' => $payment->study->Class->staff->name,
                'Book' => $payment->study->Class->book->name,
            ];
            // $queryBuilder = Study::where('class_id', $class_id);
            $columns = [ // Set Column to be displayed
                'Amount' =>'amount',
                "Month paid" => 'month_pay',
                'Date' => function($payment){
                    return Carbon::parse($payment->date);
                    return $payment->date;
                }
            ];

            return PdfReport::of($title, $meta, $queryBuilder, $columns)
                ->editColumns(['Amount'], [ // Mass edit column
                    'class' => '_text'
                ])
                ->setCss([
                    '._text' => 'font-size:18px;padding:6px',
                    '.italic-red' => 'color: red;font-style: italic;'
                ])
                ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                    'Amount' => '$' // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                ])
                ->limit(1)
                ->stream();
    }

    public function dailyReport($date){
        $title = 'Payment Daily Report '.$date; // Report title
        $queryBuilder = Payment::whereDate('created_at', '=', $date);
        
        $columns = [ // Set Column to be displayed
            'STUDENT NAME' => function($payment){
                return $payment->study->student->name;
            },
            "BOOK" => function($payment){
                return $payment->study->class->book->name;
            },
            'PAY FOR' => function($payment){
                return $payment->month_pay;
            },
            'Amount' => function($payment){
                return $payment->amount;
            }
        ];
        $meta = [ // For displaying filters description on header
           
        ];
         return PdfReport::of($title, $meta, $queryBuilder, $columns)
                ->editColumns(['Amount','PAY FOR','BOOK','STUDENT NAME'], [ // Mass edit column
                    'class' => '_text'
                ])
                ->setCss([
                    '._text' => 'font-size:18px;padding:6px',
                    '.italic-red' => 'color: red;font-style: italic;'
                ])
                ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                    'Amount' => '$' // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                ])
                ->stream();
    }

    public function grades($class_id)
    {
        try {
            $title = 'Final Result'; // Report title

            $queryBuilder = Study::join('grades', 'studies.id', '=', 'grades.study_id', 'left')
                ->orderBy(DB::raw("grades.total_score"), 'desc')
                ->select('studies.*')->where('class_id', $class_id)
                ->distinct();

            $class = Classes::find($class_id);
            //return response()->json(['d'=>$class]);
            $meta = [ // For displaying filters description on header
                'Class infomation' => ' Teacher: '.$class->staff->name.' - Book: '.$class->book->name,
                'Period' => 'Start: '.$class->start_date.' End: '.$class->end_date
            ];
            // $queryBuilder = Study::where('class_id', $class_id);
            $columns = [ // Set Column to be displayed
                'Name' => function ($study) {
                    return $study->student->name;
                },
                'QUIZ' => function ($study) {
                    $grade = $study->grade->first();
                    if (!is_null($grade)) {
                        return $study->grade->first()->quiz_score;
                    } else {
                        return "N/A";
                    }
                }, // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
                'EXAM' => function ($study) {
                    $grade = $study->grade->first();
                    if (!is_null($grade)) {
                        return $study->grade->first()->exam_score;
                    } else {
                        return "N/A";
                    }
                },
                'HOMEWORK' => function ($study) {
                    $grade = $study->grade->first();
                    if (!is_null($grade)) {
                        return $study->grade->first()->homework_score;
                    } else {
                        return "N/A";
                    }
                },
                'ATTENDENT' => function ($study) {
                    $grade = $study->grade->first();
                    if (!is_null($grade)) {
                        return $study->grade->first()->attendent_score;
                    } else {
                        return "N/A";
                    }
                },
                'TOTAL' => function ($study) {
                    $grade = $study->grade->first();
                    if (!is_null($grade)) {
                        return $study->grade->first()->total_score;
                    } else {
                        return "N/A";
                    }
                },
                'GRADE' => function ($study) {
                    $grade = $study->grade->first();
                    if (!is_null($grade)) {
                        $score = $grade->total_score;
                    } else {
                        return "N/A";
                    }
                    if ($score < 50) {
                        $grade = "F";
                    } else if ($score > 49 && $score <= 69) {
                        $grade = "D";
                    } else if ($score > 69 && $score <= 79) {
                        $grade = "C";
                    } else if ($score > 79 && $score <= 89) {
                        $grade = "B";
                    } else if ($score > 89 && $score <= 100) {
                        $grade = "A";
                    } else {
                        $grade = "N/A";
                    }
                    return $grade;
                },
                'RESULT' => function ($study) {
                    $grade = $study->grade->first();
                    if (!is_null($grade)) {
                        if ($grade->total_score > 49) {
                            return "PASSED";
                        } else {
                            return "FAILED";
                        }
                    } else {
                        return "N/A";
                    }
                }
            ];

            return PdfReport::of($title, $meta, $queryBuilder, $columns)
                ->editColumns(['No', 'Name', 'QUIZ', 'EXAM', 'HOMEWORK', 'ATTENDENT', 'TOTAL', 'GRADE', 'RESULT'], [ // Mass edit column
                    'class' => '_text'
                ])
                ->setCss([
                    '._text' => 'font-size:18px;padding:6px',
                    '.italic-red' => 'color: red;font-style: italic;'
                ])
                ->stream();
        } catch (Exception $e) {
            return response()->json(['error'=>'Class not found']);
        }
    }


    

    public function Statistic($year){
        $records = array("data"=>[],"status"=>"fails","chart_data"=>[]);
        // $year = date("Y");
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
        $pdf->loadView('report.statistic',['data'=>$records,'year'=>$year]);
        return $pdf->inline();
    }
}
