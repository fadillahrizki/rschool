<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ClassRoom;
use Validator;

class ClassRoomController extends Controller
{
    private $status_ok = 200;
    private $status_created = 201;
    private $status_bad = 400;
    private $status_forbidden = 403;

    // get all data
    function get(){
        $data = ClassRoom::get();
        foreach($data as $d){
            $data->students = $d->students;
            foreach($d->students as $student){
                $student->makeHidden('class_room_id');
            }
            $data->schedules = $d->schedules;
            foreach($d->schedules as $schedule){
                $schedule->makeHidden(['teacher_id','class_room_id']);
                $schedule->teacher = $schedule->teacher;
            }
        }
        return response()->json($data,$this->status_ok);
    }

    // get 1 data by id
    function single($id){
        $data = ClassRoom::findOrFail($id);
        $data->students = $data->students;
        foreach($data->students as $student){
            $student->makeHidden('class_room_id');
        }
        $data->schedules = $data->schedules;
        foreach($data->schedules as $schedule){
        $schedule->makeHidden(['teacher_id','class_room_id']);
            $schedule->teacher = $schedule->teacher;
        }
        return response()->json($data,$this->status_ok);
    }

    // create data
    function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message'=>'invalid field','errors'=>$validator->errors()],$this->status_forbidden);
        }

        $classRoom = ClassRoom::create([
            'name' => $request->name
        ]);

        if(!$classRoom){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'created'],$this->status_created);
    }

    function update(Request $request,$id){
    // update 1 data by id
        $classRoom = ClassRoom::findOrFail($id);

        $classRoom = $classRoom->update([
            'name'  =>  $request->name
        ]);
        
        if(!$classRoom){

            return respnse()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'updated'],$this->status_ok);
    }
    
    // delete 1 data by id
    function delete($id){
        $classRoom = ClassRoom::findOrFail($id);

        $classRoom = $classRoom->delete();

        if(!$classRoom){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'deleted'],$this->status_ok);
    }
}
