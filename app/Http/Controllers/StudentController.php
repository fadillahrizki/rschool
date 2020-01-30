<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;
use Validator;

class StudentController extends Controller
{
    private $status_ok = 200;
    private $status_created = 201;
    private $status_bad = 400;
    private $status_forbidden = 403;

    // get all data
    function get(){
        $data = Student::get();
        foreach($data as $d){
            $data->find($d->id)->makeHidden('class_room_id');
            $data->class_room = $d->class_room;
            foreach($d->absents as $absent){
                $absent->makeHidden('student_id');
            }
            $data->absents = $d->absents;
        }
        return response()->json($data,$this->status_ok);
    }

    // get 1 data by id
    function single($id){
        $data = Student::findOrFail($id);
        $data->makeHidden('class_room_id');
        $data->class_room = $data->class_room;
        foreach($data->absents as $absent){
            $absent->makeHidden('student_id');
        }
        $data->absents = $data->absents;
        return response()->json($data,$this->status_ok);
    }

    // create data
    function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'class_room_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message'=>'invalid field','errors'=>$validator->errors()],$this->status_forbidden);
        }

        $student = Student::create([
            'name' => $request->name,
            'class_room_id' => $request->class_room_id,
        ]);

        if(!$student){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'created'],$this->status_created);
    }

    function update(Request $request,$id){
    // update 1 data by id
        $student = Student::findOrFail($id);

        $student = $student->update([
            'name'  =>  $request->name,
            'class_room_id'  =>  $request->class_room_id
        ]);
        
        if(!$student){
            return respnse()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'updated'],$this->status_ok);
    }
    
    // delete 1 data by id
    function delete($id){
        $student = Student::findOrFail($id);

        $student = $student->delete();

        if(!$student){
            return response()->json(['message'=>'invalid field'],$this->status_forbidden);
        }

        return response()->json(['message'=>'deleted'],$this->status_ok);
    }
}
