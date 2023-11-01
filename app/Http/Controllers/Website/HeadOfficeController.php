<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\HeadOfficeMail;
use App\Models\HeadOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class HeadOfficeController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            
            'name'                  => 'required',
            'email'                 => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'mobile'                => 'required|numeric|digits:10',
            'company_name'         => 'required',
        ]);
        if($validator->fails()){
            return filedCall($validator->messages()); 
        }
        $data = new HeadOffice();
        
        $data->name                     = $request->name;
        $data->email                    = $request->email;
        $data->mobile                   = $request->mobile;
        $data->company_name             = $request->company_name;
        $data->address                  = $request->address;
        $data->designation              = $request->designation;
        $data->message                  = $request->message;
        $data->page_url                  = $request->page_url;

        $res                            = $data->save();
      $printReport = CommonController::PostData($request->name,'',$request->email??'',$request->mobile??'','Health checkup for the activity');
        if($res)
        {
            $details = [
                'date_time'                 => now()->toDateString(),
                'name'                      => $request->name,
                'mobile'                    => $request->mobile,
                'email'                     => $request->email,
                'company_name'              => $request->company_name,
                'address'                   => $request->address,
                'designation'               => $request->designation,
                'message'                   => $request->message,
            ];
            try{
                $sent_mail = config('constant.sentMailId');
                $bcc = config('constant.bccMailId');
                Mail::to($sent_mail)->bcc($bcc)->send(new HeadOfficeMail($details));
            }catch(\Exception $e){
                $message = 'Thanks for reach us, our team will get back to you shortly. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                return response()->json(['Status'=>200,'Errors'=>false,'Message'=>$message]);
            }
            return successCall();
        }

    }
}
