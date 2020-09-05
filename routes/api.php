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
    Route::get('/classes/joinable/{student_id}','ClassController@getJoinableClasses');
});


Route::group(['prefix' => 'feature'], function () {
    Route::get('/new_students_each_month','FeatureController@newStudentsEachMonth');
    Route::get('/classes/{teacher_id}','FeatureController@getMyClasses');
});
