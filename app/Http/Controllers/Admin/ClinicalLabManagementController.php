<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClinicalLabManagement;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use DB;

class ClinicalLabManagementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = ClinicalLabManagement::orderBy('id', 'DESC');

            return DataTables::eloquent($data)
                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    $user = Sentinel::getUser();
                    $show = '';
                    $delete = '';
                    $show =  button('show', route('clinical-lab-management.show', $data->id));
                    $delete = button('delete', route('clinical-lab-management.delete', $data->id));

                    return $show . $delete;
                })

                ->addColumn('created_at', function ($data) {
                    return date('d M Y', strtotime($data['created_at']));
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.doctors.clinical-lab-management.index');
    }
    public function destroy($id = null)
    {
        $careers  = ClinicalLabManagement::find($id);
        $careers->delete();
        Flash::success(__('action.deleted', ['type' => 'Clinical Lab Data']));
        return redirect()->back();
    }
    public function show($id)
    {
        // $data   =   ClinicalLabManagement::findOrFail($id);
        $data   =   ClinicalLabManagement::select(DB::raw("doctors_name as doctors_name,specialization as specialization,associated_hospitals_Clinics as associated_hospitals_Clinics,mobile as mobile,email as email,message as message,DATE_FORMAT(created_at,'%d/%m/%Y') as created_date,DATE_FORMAT(updated_at,'%d/%m/%Y') as updated_date,DATE_FORMAT(deleted_at,'%d/%m/%Y') as deleted_date"))->findOrFail($id);

        return view('admin.doctors.clinical-lab-management.show', compact('data'));
    }
}