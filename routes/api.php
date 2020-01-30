<?php

use Illuminate\Http\Request;

Route::prefix('v1')->group(function(){

    Route::prefix('class-room')->group(function(){
        Route::get('','ClassRoomController@get');
        Route::get('{ID}','ClassRoomController@single');
        Route::post('','ClassRoomController@create');
        Route::post('{ID}','ClassRoomController@update');
        Route::delete('{ID}','ClassRoomController@delete');
    });

    Route::prefix('student')->group(function(){
        Route::get('','StudentController@get');
        Route::get('{ID}','StudentController@single');
        Route::post('','StudentController@create');
        Route::post('{ID}','StudentController@update');
        Route::delete('{ID}','StudentController@delete');
    });

    Route::prefix('absent')->group(function(){
        Route::get('','AbsentController@get');
        Route::get('{ID}','AbsentController@single');
        Route::post('','AbsentController@create');
        Route::post('{ID}','AbsentController@update');
        Route::delete('{ID}','AbsentController@delete');
    });

    Route::prefix('teacher')->group(function(){
        Route::get('','TeacherController@get');
        Route::get('{ID}','TeacherController@single');
        Route::post('','TeacherController@create');
        Route::post('{ID}','TeacherController@update');
        Route::delete('{ID}','TeacherController@delete');
    });

    Route::prefix('schedule')->group(function(){
        Route::get('','ScheduleController@get');
        Route::get('{ID}','ScheduleController@single');
        Route::post('','ScheduleController@create');
        Route::post('{ID}','ScheduleController@update');
        Route::delete('{ID}','ScheduleController@delete');
    });

});
