<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PatientsConsumers;
use App\Http\Resources\PatientsConsumersResource;
use App\Mail\PatientsConsumersMail;
use Illuminate\Support\Facades\Mail;

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

        $filePath = 'storage/app/upload_prescription';
        $path = public_path($filePath); 
        if(!file_exists($path))
        {
            mkdir($path, 0777, true);
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
        $data->page_url                  = $request->page_url;

        $details = [
            'date_time'                 => now()->toDateString(),
            'name'                      => $request->name,
            'dob'                       => $request->dob,
            'mobile'                    => $request->mobile,
            'email'                     => $request->email,
            'gender'                    => $request->gender,
            'test_for_home_collection'  => $request->test_for_home_collection,
            'file'                      =>asset_url($file),
            'preferred_date_1'          => $request->preferred_date_1,
            'preferred_date_2'          => $request->preferred_date_2,
            'preferred_time'            => $request->preferred_time,
            'address'                   => $request->address,
            'pincode'                   => $request->pincode,
        ];
        try{
            $sent_mail = config('constant.sentMailId');
            $bcc = config('constant.bccMailId');
            Mail::to($sent_mail)->bcc($bcc)->send(new PatientsConsumersMail($details));
        }catch(\Exception $e){
            $message = 'Thanks for reach us, our team will get back to you shortly. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            return response()->json(['Status'=>200,'Errors'=>false,'Message'=>$message]);
        }
        $res = $data->save();
        $printReport = CommonController::PostData($request->name,'',$request->email ?? '',$request->mobile ??'','Patient Consumers for the activity');
        if($data)
        {
           return successCall();
        } 


    }
}
