<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactUs::select('*')
            ->when(!empty($request->start_date) && !empty($request->end_date), function ($query) use ($request) {
                $start_month     = Carbon::parse($request->start_date)->startOfDay();
                $end_month       = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$start_month, $end_month]);
            })->orderBy('contact_us.created_at','desc');
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $delete = '';
                    $view = '';
                    if (permission_check('CONTACT_US_DELETE'))
                    $delete = button('delete', route('contact-us.delete', $data->id));
                    if (permission_check('CONTACT_US_VIEW'))
                    $view = button('show', route('contact-us.view', $data->id));

                    return $view.$delete;
                })
                
                ->addColumn('created_at', function ($data) {
                    return dateFormat($data['created_at']);
                })
            
                ->rawColumns(['action', 'download'])
                ->make(true);
        }
        return view('admin.manage_contact.index');
        
      
    }
    public function delete($id = null)
    {
        $careers  = ContactUs::find($id);
        $careers->delete();
        Flash::success(__('action.deleted', ['type' => 'Career']));
        return redirect()->back();
    }
    public function view($id)
    {
        $data = ContactUs::where('id',$id)->first();
        return view('admin.manage_contact.show',compact('data'));
    }
    public function exportData(Request $request)
    {
        return Excel::download(new ContactExport($request), 'contact.xlsx');
    }
}
