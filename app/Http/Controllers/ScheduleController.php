<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Schedule;
use Validator;

class ScheduleController extends Controller
{
    private $status_ok = 200;
    private $status_created = 201;
    private $status_bad = 400;
    private $status_forbidden = 403;

    // get all data
    function get(){
        $data = Schedule::get();
        foreach($data as $d){
            $data->find($d->id)->makeHidden(['teacher_id','class_room_id']);
            $data->teacher = $d->teacher;
            $data->class_room = $d->class_room;
        }
        return response()->json($data,$this->status_ok);
    }

    // get 1 data by id
    function single($id){
        $data = Schedule::findOrFail($id);
        $data->makeHidden(['teacher_id','class_room_id']);
        $data->teacher = $data->teacher;
        $data->class_room = $data->class_room;
        return response()->json($data,$this->status_ok);
    }

    // create data
    function create(Request $request){
        $validator = Validator::make($request->all(),[
            'teacher_id' => 'required',
            'class_room_id' => 'required',
            'dt_from' => 'required',
            'dt_to' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['message'=>'invalid field','errors'=>$validator->errors()],$this->status_forbidden);
        }

        $schedule = Schedule::create([
            'teacher_id' => $request->teacher_id,
            'class_room_id' => $request->class_room_id,
            'dt_from' => $request->dt_from,
            'dt_to' => $request->dt_to,
        ]);

        if(!$schedule){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'created'],$this->status_created);
    }

    function update(Request $request,$id){
    // update 1 data by id
        $schedule = Schedule::findOrFail($id);

        $schedule = $schedule->update([
            'teacher_id' => $request->teacher_id,
            'class_room_id' => $request->class_room_id,
            'study' => $request->study,
            'dt_from' => $request->dt_from,
            'dt_to' => $request->dt_to,
        ]);
        
        if(!$schedule){
            return respnse()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'updated'],$this->status_ok);
    }
    
    // delete 1 data by id
    function delete($id){
        $schedule = Schedule::findOrFail($id);

        $schedule = $schedule->delete();

        if(!$schedule){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'deleted'],$this->status_ok);
    }
}
