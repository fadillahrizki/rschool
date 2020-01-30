<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Teacher;
use Validator;

class TeacherController extends Controller
{
    private $status_ok = 200;
    private $status_created = 201;
    private $status_bad = 400;
    private $status_forbidden = 403;

    // get all data
    function get(){
        $data = Teacher::get();
        foreach($data as $d){
            $data->schedules = $d->schedules;
            foreach($d->schedules as $schedule){
                $schedule->makeHidden(['teacher_id','class_room_id']);
                $data->schedules->class_room = $schedule->class_room;
            }
        }
        return response()->json($data,$this->status_ok);
    }

    // get 1 data by id
    function single($id){
        $data = Teacher::findOrFail($id);
        $data->schedules = $data->schedules;
        foreach($data->schedules as $schedule){
            $schedule->makeHidden(['teacher_id','class_room_id']);
            $data->schedules->class_room = $schedule->class_room;
        }
        return response()->json($data,$this->status_ok);
    }

    // create data
    function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'study' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['message'=>'invalid field','errors'=>$validator->errors()],$this->status_forbidden);
        }

        $teacher = Teacher::create([
            'name' => $request->name,
            'study' => $request->study,
        ]);

        if(!$teacher){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'created'],$this->status_created);
    }

    function update(Request $request,$id){
    // update 1 data by id
        $teacher = Teacher::findOrFail($id);

        $teacher = $teacher->update([
            'name'  =>  $request->name,
            'study'  =>  $request->study,
        ]);
        
        if(!$teacher){
            return respnse()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'updated'],$this->status_ok);
    }
    
    // delete 1 data by id
    function delete($id){
        $teacher = Teacher::findOrFail($id);

        $teacher = $teacher->delete();

        if(!$teacher){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'deleted'],$this->status_ok);
    }
}
