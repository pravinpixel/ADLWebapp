<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\NewsLetterMail;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class NewsLetterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'                 => 'required|regex:/(.+)@(.+)\.(.+)/i',
        ]);
        if($validator->fails()){
            return filedCall($validator->messages()); 
        }
        $data = NewsLetter::where('email',$request->email)->first();
        if(empty($data))
        {
            $news = new NewsLetter();
            $news->email                                             = $request->email;
            $res = $news->save();
    $printReport = CommonController::PostData('','',$request->email??'','','Health checkup for the activity');
            // $mail = 'santhoshd.pixel@gmail.com';
            $mail = config('constant.sentMailId');
            $bcc = config('constant.bccMailId');
            $details = [
                'email' => $request->email,
               
            ];
            // Mail::to($mail)->send(new \App\Mail\NewsLetterMail($details));
            try {
                $resMail = Mail::to($mail)->bcc($bcc)->send(new \App\Mail\NewsLetterMail($details));
            } catch (\Exception $e) {
                $message = 'Data inserted successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        }
        else{
            return response()->json(['Message'=>"Already Your Mail Id Subscribed to our News Letter."]);
        }
        if($res)
        {
                return successCall();
        }

    }
}
