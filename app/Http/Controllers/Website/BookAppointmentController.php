<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\BookAppointmentMail;
use App\Models\BookAppointment;
use App\Models\Cities;
use App\Models\Tests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Validator;

class BookAppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'                          => 'required',
            'location_id'                   => 'required|numeric',
            'test_id'                       => 'required|numeric',
            'mobile'                        => 'required|numeric|digits:10',
            'file'                        => 'required|mimes:png,jpg,jpeg,csv,xlx,xls,pdf,docx|max:2048',
        ]);
        if($validator->fails()){
            return filedCall($validator->messages()); 
        }
        $data = new BookAppointment();
        $data->name                                             = $request->name;
        $data->location_id                                      = $request->location_id;
        $data->mobile                                           = $request->mobile;
        $data->test_id                                          = $request->test_id;
        $data->test_type                                        = $request->test_type;
        if($request->file('file'))
        {
            if($request->has('file')) {
                if(Storage::exists($request->file)){
                    Storage::delete($request->file);
                } 
                $file               =  $request->file('file')->store('public/files/appointment');
                $data->file   =  $file;
            }
        }
        $res = $data->save();
        if($res)
        {
            $cityData = Cities::select('AreaName')->where('AreaId',$request->location_id)->first();
            $testData = Tests::select('TestName')->where('id',$request->test_id)->first();
            $details = [
                'date_time'                 => now()->toDateString(),
                'name'                      => $request->name,
                'mobile'                    => $request->mobile,
                'location'                  => $cityData['AreaName'],
                'test'                      => $testData['TestName'],
                'test_type'                 => $request->test_type,
                'file'                      => asset_url($file),
            ];
            try{
                $sent_mail = config('constant.sentMailId');
                $bcc = config('constant.bccMailId');

                Mail::to($sent_mail)->bcc($bcc)->send(new BookAppointmentMail($details));
            }catch(\Exception $e){
                $message = 'Thanks for reach us, our team will get back to you shortly. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                return response()->json(['Status'=>200,'Errors'=>false,'Message'=>$message]);
            }
                return successCall();
        }

    }
}
