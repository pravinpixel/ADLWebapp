<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\ResearchMail;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class ResearchController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'                  => 'required',
            'email'                 => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'mobile'                => 'required|numeric|digits:10',
            'city'                  => 'required',
        ]);
        if($validator->fails()){
            return filedCall($validator->messages()); 
        }
        $data = new Research();
        $data->name                     = $request->name;
        $data->email                    = $request->email;
        $data->mobile                   = $request->mobile;
        $data->city                     = $request->city;
        $data->message                  = $request->message;
        $res                            = $data->save();
        $details = [
            'name'                      => $request->name,
            'mobile'                    => $request->mobile,
            'email'                     => $request->email,
            'city'                  => $request->city,
            'message'                   => $request->message,
        ];
        try{
            // $sent_mail = "info@agdiagnostics.com";
            $sent_mail = "santhoshd.pixel@gmail.com";
            Mail::to($sent_mail)->send(new ResearchMail($details));
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
