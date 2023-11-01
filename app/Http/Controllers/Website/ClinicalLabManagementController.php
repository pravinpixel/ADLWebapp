<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\ClinicalLabManagementMail;
use App\Models\ClinicalLabManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class ClinicalLabManagementController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'doctors_name'         => 'required',
            'email'                 => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'mobile'                => 'required|numeric|digits:10',
           
        ]);
        if($validator->fails()){
            return filedCall($validator->messages()); 
        }
        $data = new ClinicalLabManagement();
        $data->doctors_name                                     = $request->doctors_name;
        $data->specialization                                   = $request->specialization;
        $data->associated_hospitals_clinics                     = $request->associated_hospitals_clinics;
        $data->email                                            = $request->email;
        $data->mobile                                           = $request->mobile;
        $data->message                                          = $request->message;
        $data->page_url                  = $request->page_url;

        $res                                                    = $data->save();
        $printReport = CommonController::PostData($request->doctors_name,'',$request->email??'',$request->mobile??'','Clinic Management for the activity');
        $details = [
            'date_time'                                        => now()->toDateString(),
            'doctors_name'                                     => $request->doctors_name,
            'specialization'                                   => $request->specialization,
            'associated_hospitals_clinics'                     => $request->associated_hospitals_clinics,
            'email'                                            => $request->email,
            'mobile'                                           => $request->mobile,
            'message'                                          => $request->message,
        ];
        try{
            $sent_mail = config('constant.sentMailId');
            $bcc = config('constant.bccMailId');
            Mail::to($sent_mail)->bcc($bcc)->send(new ClinicalLabManagementMail($details));
        }catch(\Exception $e){
            $message = 'Thanks for reach us, our team will get back to you shortly. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            return response()->json(['Status'=>200,'Errors'=>false,'Message'=>$message]);
        }

        if($res)
        {
                return successCall();
        }

    }
}
