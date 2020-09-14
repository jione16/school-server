<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use PdfReport;
class Reportcontroller extends Controller
{
    //
    public function test(Request $request){
        $books = new Book;
        return response()->json(['data'=>$books->get()]);
    }

    public function report(Request $request){
        $title = 'Testing Report'; // Report title

        $meta = [ // For displaying filters description on header
            'Registered on' => 'wehh?',
            'Sort By' => 'hahh?'
        ];

        $queryBuilder = Book::select(['language','name']);

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
}
