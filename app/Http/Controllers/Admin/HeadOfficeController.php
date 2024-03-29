<?php

namespace App\Http\Controllers\Admin;

use App\Exports\HeadOfficeExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeadOffice;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class HeadOfficeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = HeadOffice::when(!empty($request->start_date) && !empty($request->end_date), function ($query) use ($request) {
                $start_month     = Carbon::parse($request->start_date)->startOfDay();
                $end_month       = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$start_month, $end_month]);
            })->orderBy('id', 'DESC');

            return DataTables::eloquent($data)
                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    $user = Sentinel::getUser();
                    $show = '';
                    $delete = '';

                    if (permission_check('HEALTHCHECKUP_FOR_EMPLOYEE_SHOW'))
                    $show =  button('show', route('healthcheckup-for-employee.show', $data->id));


                    if (permission_check('HEALTHCHECKUP_FOR_EMPLOYEE_DELETE'))
                    $delete = button('delete', route('healthcheckup-for-employee.delete', $data->id));

                    return $show . $delete;
                })

                ->addColumn('created_at', function ($data) {
                    return dateFormat($data['created_at']);
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.reach-us.head-office.index');
    }
    public function destroy($id = null)
    {
        $careers  = HeadOffice::find($id);
        $careers->delete();
        Flash::success(__('action.deleted', ['type' => 'Home Collection']));
        return redirect()->back();
    }
    public function show($id)
    {
        // $data   =   HeadOffice::findOrFail($id);
        $data   =   HeadOffice::select(DB::raw("name as name,company_name as company_name,mobile as mobile,email as email,designation as 
        designation,message as message,address as address,DATE_FORMAT(created_at,'%d/%m/%Y') as created_date"))->findOrFail($id);

        return view('admin.reach-us.head-office.show', compact('data'));
    }
    public function exportData(Request $request)
    {
        return Excel::download(new HeadOfficeExport($request), 'head_office.xlsx');
    }
}
