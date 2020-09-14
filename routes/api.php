<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/student_search','StudentController@search');
Route::get('/staff_search','StaffController@search');
Route::get('/book_search','BookController@search');
Route::get('/room_search','RoomController@search');
Route::resource("/student","StudentController");
Route::resource("/staff","StaffController");
Route::resource("/book","BookController");
Route::resource("/room","RoomController");
Route::resource("/classes","ClassController");
Route::resource('/studies', 'StudyController');
Route::resource('/grades','GradeController');
Route::resource('/payment','PaymentController');

Route::group(['prefix' => 'obj'], function () {

    Route::get('/studies_grade/{class_id}','StudyController@getStudiesByClass');
    Route::get('/classes','ClassController@objAll');
    Route::get('/class_object','ClassController@getRegisterData');
    Route::get('/students','StudentController@getAllStudents');
    Route::get('/teachers','StaffController@getAllTeachers');
    Route::get('/studies/{student_id}','StudyController@getStudies');
    Route::get('/studies_payment/{student_id}','StudyController@getStudiesPayments');
    Route::get('/classes/joinable/{student_id}','ClassController@getJoinableClasses');
});


Route::group(['prefix' => 'feature'], function () {
    Route::get('/get_stat','FeatureController@getStatEachMonth');
    Route::get('/new_students_each_month','FeatureController@newStudentsEachMonth');
    Route::get('/classes/{teacher_id}','FeatureController@getMyClasses');
    Route::get('/get_dashboard_count','FeatureController@getDashboardCount');
});

Route::get('/test','ReportController@test');
Route::get('/report','ReportController@report');
