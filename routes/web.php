<?php
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::any('/employee/import', 'Employee\EmployeeController@import');

Route::get('/attendance', 'Attendance\AttendanceController@store');

Route::get('/filess', 'FileController@getFileLists')->name('getFiles');
Route::get('/dead-code', 'FileController@findDeadCodes')->name('findDeadCodes');
Route::get('/filesInfo', 'FileController@index')->name('getInfo');
