<?php

namespace App\Exports;

use App\Models\FeedBack;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class FeedBackB2BExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $type =  request()->route()->type ?? 'feedback';
     $feedbacks=FeedBack::where('type',$type)->select('name','corporate_id','remark','created_at','qa_comments')->get();
     $form_data=[];
     foreach($feedbacks as $feedback){
        $data=[];
              if(isset($feedback['qa_comments'])){
                foreach(json_decode($feedback['qa_comments']) as $comment){ 
                    $data[]=$comment->question.' | '.(($comment->answer==1)?'Yes':'No');   
                }
              }
              $form_data[]=[
                       'name'=>$feedback['name'],
                       'corporate_id'=>$feedback['corporate_id'],
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
     $row['name'], $row['corporate_id'],$row['remark'], $row['created_at'],implode(",\n", $row['comments'])
        ];
    }
    public function headings(): array
    {
        return [
            'Name of the Organization',
            'B2B Corporate ID',
            'Remark',
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
