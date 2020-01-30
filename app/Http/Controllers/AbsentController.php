<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Absent;
use Validator;

class AbsentController extends Controller
{
    private $status_ok = 200;
    private $status_created = 201;
    private $status_bad = 400;
    private $status_forbidden = 403;

    // get all data
    function get(){
        $data = Absent::get();
        foreach($data as $d){
            $data->find($d->id)->makeHidden('student_id');
            $data->student = $d->student;
            $data->find($d->id)->student->makeHidden('class_room_id');
            $data->student->class_room = $d->student->class_room;
        }
        return response()->json($data,$this->status_ok);
    }

    // get 1 data by id
    function single($id){
        $data = Absent::findOrFail($id);
        $data->makeHidden('student_id');
        $data->student = $data->student;
        $data->student->makeHidden('class_room_id');
        $data->student->class_room = $data->student->class_room;
        return response()->json($data,$this->status_ok);
    }

    // create data
    function create(Request $request){
        $validator = Validator::make($request->all(),[
            'student_id' => 'required',
            'status' => 'required',
            'date' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message'=>'invalid field','errors'=>$validator->errors()],$this->status_forbidden);
        }

        $absent = Absent::create([
            'student_id'=>$request->student_id,
            'status' => $request->status,
            'date'=>$request->date
        ]);

        if(!$absent){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'created'],$this->status_created);
    }

    function update(Request $request,$id){
    // update 1 data by id
        $absent = Absent::findOrFail($id);

        $absent = $absent->update([
            'student_id'=>$request->student_id,
            'status' => $request->status,
            'date_time'=>$request->date_time
        ]);
        
        if(!$absent){

            return respnse()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'updated'],$this->status_ok);
    }
    
    // delete 1 data by id
    function delete($id){
        $absent = Absent::findOrFail($id);

        $absent = $absent->delete();

        if(!$absent){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'deleted'],$this->status_ok);
    }
}
