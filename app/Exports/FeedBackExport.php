<?php

namespace App\Exports;

use App\Models\FeedBack;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class FeedBackExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $type =  request()->route()->type ?? 'feedback';
     $feedbacks=FeedBack::where('type',$type)->select('name','reg_no','mobile','branch','remark','created_at','qa_comments')->get();
     $form_data=[];
     foreach($feedbacks as $feedback){
        $data=[];
              if(isset($feedback['qa_comments'])){
             
                foreach(json_decode($feedback['qa_comments']) as $key=>$comment){ 
               
                    $data[]=$comment->question.' | '.(($key==0)? $comment->answer :(($comment->answer==1)?'Yes':'No'));
                  
                    
                }
              }
              $form_data[]=[
                       'name'=>$feedback['name'],
                       'reg_no'=>$feedback['reg_no'],
                       'mobile'=>$feedback['mobile'],
                       'branch'=>$feedback['branch'],
                       'remark'=>$feedback['remark'],
                       'created_at'=>$feedback['created_at'],
                       'comments'=> $data
              ];
     }
     return collect($form_data);
    }
    public function map($row): array
    {
        return [
     $row['name'], $row['reg_no'], $row['mobile'],$row['branch'],$row['remark'], $row['created_at'],implode(",\n", $row['comments'])
        ];
    }
    public function headings(): array
    {
        return [
            'Rretain Name',
            'Registration Number',
            'Mobile',
            'Branch',
            'Remarks',
            'Created Date',
            'Comments'
        ];
    }
    public function columns(): array
    {
        return [
           
           
        ];
    }
}
