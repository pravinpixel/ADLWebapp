<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\CareersMail;
use App\Models\Career;
use App\Models\JobPost;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CareerController extends Controller
{
    public function getJobDetail($id)
    {
        $jobDetail = JobPost::where('job_posts.id',$id)
        ->select('job_posts.id','job_posts.title','job_posts.code','job_posts.location','job_posts.department_id','job_posts.experience',
        'job_posts.responsibilities','job_posts.qualification','job_posts.no_of_requirement','departments.name as department_name')
        ->leftJoin('departments','departments.id','job_posts.department_id')
        ->first();
        if(!empty($jobDetail))
        {
            return response()->json(['job'=>$jobDetail]);
        }
        else{
            return response()->json(['Message'=>"Data not Find"]);
        }
    }
    public function jobApply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'mobile' => 'required|numeric|digits:10',
            'file'   => 'required|mimes:doc,pdf,docx'
        ]);
        if ($validator->fails()) {
            return filedCall($validator->messages()); 
        }

        $data = new Career;
        $data->job_id = $request->job_id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->message = $request->message;
        if($request->file)
        {
            $filePath = 'website/upload/careers';
            $path = public_path($filePath); 
            if(!file_exists($path))
            {
                mkdir($path, 0777, true);
            }
            if($request->has('file')) {
                if(Storage::exists($request->file)){
                    Storage::delete($request->file);
                } 
                $file               =  $request->file('file')->store('public/files/career');
                $data->file   =  $file;
            } 
        }
        $res = $data->save();
    if($res)
        {
            $jobData  = JobPost::find($request->job_id);
            $details = [
                'date_time'                 => now()->toDateString(),
                'name'                  =>$request->name,
                'email'                 =>$request->email,
                'mobile'                =>$request->mobile,
                'job'                   =>$jobData['title'],
                'message'               =>$request->message,
                'file'                  =>asset_url($file),
            ];
            try{
                $sent_mail = config('constant.sentMailId');
                $bcc = config('constant.bccMailId');
                Mail::to($sent_mail)->bcc($bcc)->send(new CareersMail($details));
            }catch(\Exception $e){
                $message = 'Thanks for reach us, our team will get back to you shortly. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                return response()->json(['Status'=>200,'Errors'=>false,'Message'=>$message]);
            }
            return response()->json(['Status'=>200,'Errors'=>false,'Message'=>'Thank you for Applying']);

        }
        $error = 1;
        return response()->json(['error'=>$error,'message'=>"something went wrong."]);

    }
}
