<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FeedBackExport;
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
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = FeedBack::orderBy('id', 'DESC');

            return DataTables::eloquent($data)
                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    $user = Sentinel::getUser();
                    $show = '';
                    $delete = '';

                    if (permission_check('FEEDBACK_SHOW'))
                    $show =  button('show', route('feedback.show', $data->id));

                    if (permission_check('FEEDBACK_DELETE'))
                    $delete = button('delete', route('feedback.delete', $data->id));

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
    public function destroy($id = null)
    {
        $careers  = FeedBack::find($id);
        $careers->delete();
        Flash::success(__('action.deleted', ['type' => 'FeedBack']));
        return redirect()->back();
    }
    public function show($id)
    {
        // $data   =   FeedBack::findOrFail($id);
        $data   =   FeedBack::select(DB::raw("qa_comments,name as name,mobile as mobile,email as email,location as location,message as message,
        DATE_FORMAT(created_at,'%d/%m/%Y') as created_date"))->findOrFail($id);
        return view('admin.enquiry.feedback.show', compact('data'));
    }
    public function exportData(Request $request)
    {
        return Excel::download(new FeedBackExport, 'feedback.xlsx');
    }
}
