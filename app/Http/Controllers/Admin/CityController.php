<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laracasts\Flash\Flash;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Cities::select([
                "id",
                "CityID",
                "CityName",
                "AreaId",
                "AreaName",
                "Pincode",
                "State",
            ]);
            return DataTables::eloquent($data)->addIndexColumn()->make(true);
        }
        $last_sync  =   Carbon::parse(Cities::latest()->first()->created_at ?? "")->format('d/m/Y');

        return view('admin.master.city.index', compact('last_sync'));
    }
    
    public function syncRequest()
    {
        $response = Http::get('http://reports.anandlab.com/listest/labapi.asmx/GetCityMaster', [
            'CorporateID'   =>    config('auth.CorporateID'),
            'passCode'      =>    config('auth.passCode'),
        ]);

        $response_data = json_decode($response->body())[0]->Data;

        foreach ($response_data as $data) {
            Cities::updateOrCreate([
                "CityID"    =>  $data->CityID ?? null,
                "CityName"  =>  $data->CityName ?? null,
                "AreaId"    =>  $data->AreaId ?? null,
                "AreaName"  =>  $data->AreaName ?? null,
                "Pincode"   =>  $data->Pincode ?? null,
                "State"     =>  $data->State ?? null,
            ]);
        }

        Flash::success( __('masters.sync_success'));

        return redirect()->back();
    }
}
