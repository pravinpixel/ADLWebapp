<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\FeedBackMail;
use Validator;
use Illuminate\Http\Request;
use App\Models\FeedBack;
use Illuminate\Support\Facades\Mail;
class FeedBackController extends Controller
{
    function formatQacomments($request)
    {
        $qa = [];
        $qac = [];
        $temp = [];
        foreach ($request as $key => $value) {
            $formatedKey = str_replace('-', ' ', str_replace(['QA_', 'QAC_'], '', $key));
            if (strstr($key, 'QA_')) {
                $qa[] = [$formatedKey => $value];
            }
            if (strstr($key, 'QAC_')) {
                $qac[] = [$formatedKey => $value];
            }
        }
        if ($request['type']=='feedback-b2b'){
            foreach ($qa as $key => $value) {
                $temp[] = [
                    "question" => ucfirst(array_keys($value)[0]) . "?",
                    "answer" => array_values($value)[0] ?? '',
                    
                ];
            }
            return  $temp;
        } else { 
            foreach ($qa as $key => $value) {
                $temp[] = [
                    "question" => array_keys($value)[0] ?? '-',
                    "answer" => array_values($value)[0] ?? '-',
                ];
            }
            return  $temp;
        }
    }
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'type'   => 'required|in:feedBack,feedback-b2b',
            'name'   => 'required|string',
            'reg_no'  => 'required_if:type,feedBack',
            'branch'  => 'required_if:type,feedBack',
            'mobile' => 'required_if:type,feedBack|numeric|digits:10',
            'remark' => 'required|string',
            'corporate_id' => 'required_if:type,feedback-b2b'
        ]);
        if ($validator->fails()) {
            return filedCall($validator->messages());
        }
        if($request->type=='feedBack'){
              $type='FeedBack for the activity';
          }else{
              $type='Feedback-b2b for the activity';
          }
        $printReport = CommonController::PostData($request->name,'','',$request->mobile??'',$type);
        $question_answer   = $this->formatQacomments($request->all());
        $data              = new FeedBack;
        $data->name        = $request->name;
        $data->type        = $request->type;
        $data->corporate_id = $request->corporate_id ?? Null;
        $data->reg_no       = $request->reg_no?? Null;
        $data->branch       = $request->branch?? Null;
        $data->email       = $request->email?? Null;
        $data->mobile      = $request->mobile?? Null;
        $data->location    = Null;
        $data->remark      =$request->remark;
        $data->message     = $request->message?? Null;
        $data->page_url    = $request->page_url?? Null;
        $data->qa_comments = json_encode($question_answer);
        
        if ($data->save()) {
            if($request->type=='feedBack'){
             $details = [
                'name'            => $request->name,
                'mobile'          => $request->mobile,
                'branch'          => $request->branch,
                'reg_no'           => $request->reg_no,
                'remark'         => $request->remark,
                'date_time'       => now()->toDateString(),
                'rating_comments' => $request->rating,
                'page_url'        => $request->page_url,
                'question_answer' => $question_answer,
                'type'=>'feedback'
            ];
            }else{
           $details = [
                'name'            => $request->name,
                'corporate_id'          => $request->corporate_id,
                'remark'         => $request->remark,
                'date_time'       => now()->toDateString(),
                'rating_comments' => $request->rating,
                'page_url'        => $request->page_url,
                'question_answer' => $question_answer,
                'type'=>'feedbackb2b'
            ];

            }
            try {
                Mail::to(config('constant.sentMailId'))->bcc(config('constant.bccMailId'))->send(new FeedBackMail($details));
                
            } catch (\Exception $e) {
                $message = 'Thanks for reach us, our team will get back to you shortly. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                return response()->json(['Status' => 200, 'Errors' => false, 'Message' => $message]);
            }
            return successCall();
        }
    }
}
