<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PatientsConsumers;
use App\Http\Resources\PatientsConsumersResource;

class PatientsConsumersController extends Controller
{
    // public function index($id)
    // {
    //     $data = PatientsConsumers::find($id);
    //     return new PatientsConsumersResource($data);
    // }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'email'     => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'mobile'    => 'required|numeric|digits:10',
            'dob'      => 'required|date',
            'gender'    => 'required',
        ]);
        if($validator->fails()){
            return filedCall($validator->messages()); 
        }
        $file = Storage::put('upload_prescription', $request->file('upload_prescription'));
        $data = new PatientsConsumers;
        $data->name                     = $request->name ;
        $data->dob                      = $request->dob ;
        $data->mobile                   = $request->mobile ;
        $data->email                    = $request->email ;
        $data->gender                   = $request->gender;
        $data->test_for_home_collection = $request->test_for_home_collection ;
        $data->upload_prescription      = $file ;
        $data->preferred_date_1         = $request->preferred_date_1 ;
        $data->preferred_date_2         = $request->preferred_date_2 ;
        $data->preferred_time           = $request->preferred_time;
        $data->address                  = $request->address;
        $data->pincode                  = $request->pincode;

        $res = $data->save();
        if($data)
        {
           return successCall();
        } 


    }
}
