<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FeedBackExport;
use App\Exports\FeedBackB2BExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedBack;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class FeedBackController extends Controller
{
    public function index(Request $request, $type = 'feedback')
    {
        if ($request->ajax()) {

            $data = FeedBack::where('type',$type)->orderBy('id', 'DESC');

            return DataTables::eloquent($data)
                ->addIndexColumn()

                ->addColumn('action', function ($data) use ($type) {
                    $user = Sentinel::getUser();
                    $show = '';
                    $delete = '';

                    if (permission_check('FEEDBACK_SHOW'))
                        $show =  button('show', route('feedback.show', ["type" => $type, "id" =>  $data->id]));

                    if (permission_check('FEEDBACK_DELETE'))
                        $delete = button('delete', route('feedback.delete', ["type" => $type, "id" =>  $data->id]));

                    return $show . $delete;
                })

                ->addColumn('created_at', function ($data) {
                    return dateFormat($data['created_at']);
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.enquiry.feedback.index');
    }
    public function destroy(Request $request,$id)
    {
   
        $careers  = FeedBack::find($id);
        $careers->delete();
       if($request->type=='feedback'){
        Flash::success(__('action.deleted', ['type' => 'FeedBack']));
       }else{
        Flash::success(__('action.deleted', ['type' => 'FeedBackB2B']));
       }
      
        return redirect()->back();
    }
    public function show($type, $id)
    {
     if($type=='feedback'){
        $data   =   FeedBack::select(DB::raw("qa_comments,page_url,name as retain_name,reg_no as registration_number,mobile as mobile,branch as branch,remark as remark,
        DATE_FORMAT(created_at,'%d/%m/%Y') as created_date"))->findOrFail($id);
     }else{
        $data   =   FeedBack::select(DB::raw("qa_comments,page_url,name as name_of_the_organization,corporate_id as B2B_Corporate_Id,remark as remark,
        DATE_FORMAT(created_at,'%d/%m/%Y') as created_date"))->findOrFail($id);
     }
     
        return view('admin.enquiry.feedback.show', compact('data'));
    }
    public function exportData(Request $request)
    {
       if($request->type=='feedback'){
        return Excel::download(new FeedBackExport, 'feedback.xlsx');
       }else{
        return Excel::download(new FeedBackB2BExport, 'feedbackb2b.xlsx');
       }
      
    }
    
}
