<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Study;
use PdfReport;
use DB;
use App\Classes;
use Exception;
class Reportcontroller extends Controller
{
    //
    public function test(Request $request)
    {
        $books = new Book;
        return response()->json(['data' => $books->get()]);
    }

    public function report(Request $request)
    {
        $title = 'Final Result'; // Report title

        $meta = [ // For displaying filters description on header
            'Registered on' => 'wehh?',
            'Sort By' => 'hahh?'
        ];

        $queryBuilder = Book::select(['language', 'name']);

        $columns = [ // Set Column to be displayed
            'Name' => 'name',
            'Registered At', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
            'Language' => 'language'
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns)
            ->limit(20) // Limit record to be showed
            ->stream(); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
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
                'Info' => ' Teacher '.$class->staff->name.' - Book: '.$class->book->name,
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
}
