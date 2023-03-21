<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NewsLetterExport;
use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Yajra\DataTables\Facades\DataTables;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Facades\Excel;

class NewsLetterController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {

            $data = NewsLetter::select([
                'id',
                'email',
            ])->orderBy('id','desc');

            return DataTables::eloquent($data)
                ->addIndexColumn()
                          
                ->addColumn('action', function ($data) {
                    $user = Sentinel::getUser();
                    $show = '';
                    $delete = '';
                    if (permission_check('NEWS_LETTER_SHOW'))
                    $show =  button('show', route('news-letter.show', $data->id));

                    if (permission_check('NEWS_LETTER_DELETE'))
                    $delete = button('delete', route('news-letter.delete', $data->id));
                    return $show . $delete;
                })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.news-letter.index');
    }
   
    public function delete($id = null)
    {
        $careers  = NewsLetter::find($id);
        $careers->delete();
        Flash::success(__('action.deleted', ['type' => 'Subscriber Email']));
        return redirect()->back();
    }
    public function show($id)
    {
        $data   =   NewsLetter::select('id','email','created_at')->find($id);
        return view('admin.news-letter.show', compact('data'));
    }
    public function exportData(Request $request)
    {
        return Excel::download(new NewsLetterExport, 'news_letter.xlsx');
    }
}
