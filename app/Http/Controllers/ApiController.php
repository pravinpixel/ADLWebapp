<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use App\Models\CustomerDetails;
use App\Models\NewsEvent;
use App\Models\PaymentConfig;
use App\Models\SubTests;
use App\Models\Tests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Razorpay\Api\Api;

class ApiController extends Controller
{
    public function banners()
    {
        $data = Banners::latest()->get();
        return response()->json([
            "status"    =>  true,
            "data"      =>  $data
        ]);
    }
    public function topBookedTest()
    {
        $data   = Tests::oldest()->limit(10)->get();
        return response()->json([
            "status"    =>  true,
            "data"      =>  $data
        ]);
    }
    public function testDetails($id)
    {
        $data    = Tests::find($id);
        $subData = SubTests::where("TestId", $data->id)->get();
        return response()->json([
            "status"    =>  true,
            "data"      =>  [
                "test"      => $data,
                "sub_test"  => $subData,
            ]
        ]);
    }
    public function bannerContactForm(Request $request)
    {
        Storage::put('contact', $request->file('reportFile'));
        return response()->json([
            "status"    =>  true,
            "message"   =>  "Form Submit Success !"
        ]);
    }
    public function testLists(Request $request,$type=null)
    {
        if(is_null($type)) {
            $IsPackage = 'No';
        } else {
            $IsPackage = 'Yes';
        }
        $data   =   Tests::with('SubTestList')
                            ->where('TestName', 'like', '%'.$request->search.'%')
                            ->where('IsPackage', $IsPackage)
                            ->skip(0)
                            ->take($request->tack)
                            ->orderBy('TestPrice', ($request->sort == 'low' ? "DESC" : null) === null ? "DESC" : 'ASC'  )
                            ->get();
        return response()->json([
            "status"    =>  true,
            "data"      =>  $data
        ]);
    }
    public function newsAndEvents()
    {
        return response()->json([
            "status"    =>  true,
            "data"      =>  NewsEvent::all()
        ]);
    }
    public function register(Request $request)
    {
        $User = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            "status"    =>  true,
            "data"      =>  $User
        ]);
    }
    public function update_billing_address(Request $request)
    {
        $customerInfo = $request->all();
        unset($customerInfo['amount']);
        $customer = User::with('CustomerDetails')->find($request->id);
        $customer->CustomerDetails()->updateOrCreate($customerInfo);
        
        $api = new Api(config('payment.KeyID'), config('payment.KeySecret'));
        $Order = $api->order->create([
            'amount'   => (int) $request->amount * 100,
            'currency' => 'INR'
        ]);

        return response([
            "status" => true,
            "data" => [
                "key" => PaymentConfig::where('gateWayName','RAZOR_PAY')->first()->payKeyId ?? config('payment.KeyID'),
                "title" => "Pay Online",
                "image" => asset('/public/images/logo/favicon.png'),
                "name" => $customer->name,
                "email" => $customer->email,
                "contact" => $customer->CustomerDetails['phone_number'] ?? null,
                "order_id" => $Order['id']
            ]
        ]);
    }
}
