<?php

namespace App\Http\Controllers;

use App\Mail\HomeCollectionMail;
use App\Mail\ResetPasswordMail;
use App\Models\Banners;
use App\Models\BookHomeCollection;
use App\Models\Branch;
use App\Models\Cart;
use App\Models\Cities;
use App\Models\Conditions;
use App\Models\NewsEvent;
use App\Models\Orders;
use App\Models\Organs;
use App\Models\Packages;
use App\Models\PaymentConfig;
use App\Models\SubTests;
use App\Models\Tests;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Http;
use Razorpay\Api\Errors\SignatureVerificationError;

class ApiController extends Controller
{
    public function banners()
    {
        $data = Banners::orderBy('OrderBy')->get();
        $banner = [];
        foreach ($data as $item) {
            $banner[] = [
                'Title' => $item->Title,
                'Content' => $item->Content,
                'Url' => $item->Url,
                'DesktopImage' => asset_url($item->DesktopImage),
                'MobileImage' => asset_url($item->MobileImage),
                'OrderBy' => $item->OrderBy,
                'Status' => $item->Status
            ];
        }
        return response()->json([
            "status"    =>  true,
            "data"      =>  $data
        ]);
    }
    public function topBookedTest()
    {
        $data   = Tests::with('TestPrice')->oldest()->limit(10)->get();
        return response()->json([
            "status"    =>  true,
            "data"      =>  $data
        ]);
    }
    public function testDetails(Request $request, $slug)
    {
        $data   = Tests::where('TestSlug', $slug)->join('test_prices', function($join) {
            $join->on('test_prices.TestId', '=', 'tests.id');
        })
        // 
        ->where('test_prices.TestLocation', '=', $request->TestLocation)
        ->first();
        $data['image'] = asset_url($data->image);
        $subData = SubTests::where("TestId", $data->id)->get();
        if ($data === null) {
            return response()->json([
                "status"    =>  false,
            ]);
        }
        return response()->json([
            "status"    =>  true,
            "data"      =>  [
                "test"      => $data,
                "sub_test"  => $subData ?? [],
            ]
        ]);
    }
    public function bannerContactForm(Request $request)
    {
        $file = Storage::put('contact', $request->file('reportFile'));
        BookHomeCollection::create([
            "name"      => $request->name,
            "mobile"    => $request->mobile,
            "location"  => $request->location,
            "file"      => $file,
            "test_name" => $request->test_name,
            "comments"  => $request->comments,
        ]);
        $details = [
            'site_logo'             => asset('/images/logo/logo.png'),
            'name'                  => $request->name,
            'mobile'                => $request->mobile,
            'location'              => $request->location,
            'file'                  => asset_url($file),
            'test_name'             => $request->test_name,
            'comments'              => $request->comments,
            'date_time'             => now()->toDateString(),
        ];
        try {
            $sent_mail = "donotreply@anandlab.com";
            // $sent_mail = "santhoshd.pixel@gmail.com"; 
            Mail::to($sent_mail)->send(new HomeCollectionMail($details));
        } catch (\Exception $e) {
            $message = 'Thanks for reach us, our team will get back to you shortly. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            return response()->json(['Status' => 200, 'Errors' => false, 'Message' => $message]);
        }
        return response()->json([
            "status"    =>  true,
            "message"   =>  "Form Submit Success !"
        ]);
    }
    public function testLists(Request $request)
    {
        $data   =   Tests::when(!empty($request->TestName), function ($query) use ($request) {
                $query->where('TestName', 'like', '%' . $request->TestName . '%');
            })
            ->when(!empty($request->OrganName), function ($query) use ($request) {
                $query->where('OrganName', $request->OrganName);
            })
            ->when(!empty($request->HealthCondition), function ($query) use ($request) {
                $query->where('HealthCondition', 'like', '%' . $request->HealthCondition . '%');
            })
            ->skip(0)
            ->take($request->Tack)
            ->join('test_prices', function($join) {
                $join->on('test_prices.TestId', '=', 'tests.id');
            })
            ->where('test_prices.TestLocation', '=', $request->TestLocation)
            ->orderBy('test_prices.TestPrice', $request->orderBy)
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
    public function login(Request $request)
    {
        $User = User::with('CustomerDetails')->where('email', $request->email)->first();
        if (!is_null($User)) {
            if (Hash::check($request->password, $User->password)) {
                return response()->json([
                    "status"     => true,
                    "data"       => $User,
                    "cart_items" => $this->cart_items($User->id),
                    "message"    => "Login Success !"
                ]);
            } else {
                return response()->json([
                    "status"    =>  false,
                    "message"  =>  'Password or Email id Wrong !'
                ]);
            }
        }
        return response()->json([
            "status"    =>  false,
            "message"   =>  'User Not Found !'
        ]);
    }
    public function login_with_otp(Request $request)
    {
        $user = User::with('CustomerDetails')->where('email', $request->email)->first();
        if (!is_null($user)) {
            $otp = rand(11111, 99999);
            Http::post('https://reports.anandlab.com/v3/SMS.asmx/SendWebsiteOTP', [
                'otp'       => $otp,
                'mobile_no' => $user->mobile,
                'api_key'   => 'FC033590-B038-4CCD-BC8F-13BE890BF9F0',
            ]);
            return response()->json([
                "status"  => true,
                "otp"     => $otp,
                "data"    => $user,
                "message" => "Login Success !"
            ]);
        }
        return response()->json([
            "status"    =>  false,
            "message"   =>  'User Not Found !'
        ]);
    }
    public function register(Request $request)
    { 
        if (!is_null(User::where('email', $request->email)->first()) ) {
            return response()->json([
                "status"    =>  false,
                "message" =>  'Email Id Already exists !'
            ]);
        }
        if (!is_null(User::where('mobile', $request->mobile)->first()) ) {
            return response()->json([
                "status"    =>  false,
                "message" =>  'Mobile Number Already been tacken !'
            ]);
        }
        $User = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'mobile'    => $request->mobile,
            'role_id'  => 0,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            "status"    =>  true,
            "data"      =>  $User
        ]);
    }
    public function update_customer(Request $request, $id)
    {
        $customer = User::with('CustomerDetails')->find($id);
        $customer->update([
            'name' => $request->name
        ]);
        $customer->CustomerDetails()->updateOrCreate([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'address'      => $request->address,
            'city_town'    => $request->city_town,
            'state'        => $request->state,
            'pin_code'     => $request->pin_code,
        ]);
        return response()->json([
            "status"  => true,
            "message" => 'Your Information Updated !',
            "data"    => $customer
        ]);
    }
    public function update_billing_address(Request $request)
    {
        $customerInfo = $request->all();
        unset($customerInfo['amount']);
        $customer = User::with('CustomerDetails')->find($request->id);
        if (!is_null($customer->CustomerDetails() ?? null)) {
            $customer->CustomerDetails()->delete();
        }
        $customer->CustomerDetails()->create($customerInfo);

        $api = new Api(PaymentApiConfig()->payKeyId, PaymentApiConfig()->paySecretKey);
        $Order = $api->order->create([
            'amount'   => (int) $request->amount * 100,
            'currency' => 'INR'
        ]);

        return response([
            "status" => true,
            "data" => [
                "key"      => PaymentConfig::where('gateWayName', 'RAZOR_PAY')->first()->payKeyId ?? config('payment.KeyID'),
                "title"    => "Pay Online",
                "image"    => asset('/public/images/logo/favicon.png'),
                "name"     => $customer->name,
                "email"    => $customer->email,
                "contact"  => $customer->CustomerDetails['phone_number'] ?? null,
                "order_id" => $Order['id'],
                "user"     => $customer
            ]
        ]);
    }

    public function save_payment_order(Request $request)
    {
        $result =  $this->CheckValidOrder($request->razorpay_response);

        if ($result['status'] == false) {
            $message = "Payment Failed";
            $status = 0;
        } else {
            $message = "Payment Success";
            $status = 1;
        }

        $Order = Orders::create([
            'payment_id'        => $result['payment_id'],
            'razorpay_order_id' => $result['order_id'],
            'user_id'           => $request->user['id'],
            'appoinment'        => $request->appoinment,
            'datetime'          => $request->datetime,
            'payment_status'    => $status,
            "order_response"    => $result['order_response'],
            "order_amount"      => $request->total_price
        ]);

        $Order->update([
            'order_id' => OrderId($Order->id),
        ]);

        if (count($request->products)) {
            foreach ($request->products as $key => $product) {
                $Order->Tests()->create($product);
            }
        }
        return response()->json([
            "status" => $result['status'],
            "message" => $message
        ]);
    }

    public function CheckValidOrder($response)
    {
        $api    = new Api(PaymentApiConfig()->payKeyId, PaymentApiConfig()->paySecretKey);
        if ($response['status'] == 'PAID') {
            $order_response = $api->order->fetch($response['data']['razorpay_order_id']);
            $payment_id =   $response['data']['razorpay_payment_id'];
            $order_id   =   $response['data']['razorpay_order_id'];
            if (isset($order_response['status']) && $order_response['status'] == 'paid') {
                $status = true;
            }
            try {
                $api->utility->verifyPaymentSignature([
                    'razorpay_order_id'   => $order_id,
                    'razorpay_payment_id' => $payment_id,
                    'razorpay_signature'  => $response['data']['razorpay_signature']
                ]);
            } catch (SignatureVerificationError $e) {
                $error = 'Razorpay Error : ' . $e->getMessage();
                $status = false;
            }
        } else {
            if (isset($response['data']['error'])) {
                $payment_id     = $response['data']['error']['metadata']['payment_id'];
                $order_id       = $response['data']['error']['metadata']['order_id'];
                $order_response = $api->order->fetch($order_id);
                $status         = false;
            }
        }

        return [
            "status"         => $status,
            "payment_id"     => $payment_id,
            "order_id"       => $order_id,
            "order_response" => serialize($order_response)
        ];
    }

    public function customer_info($id)
    {
        $customer = User::with('CustomerDetails')->find($id);
        return [
            "status" => true,
            "data"   => $customer
        ];
    }
    public function packages(Request $request)
    {
        $Tests = Tests::with('SubTests')->where('IsPackage',"Yes")
            ->when(!empty($request->ApplicableGender), function ($query) use ($request) {
                $query->whereIn('ApplicableGender', $request->ApplicableGender);
            })
            ->when(!empty($request->OrganName), function ($query) use ($request) {
                $query->whereIn('OrganName', $request->OrganName);
            })
            ->when(!empty($request->HealthCondition), function ($query) use ($request) {
                $query->whereIn('HealthCondition', $request->HealthCondition);
            })
            ->join('test_prices', function($join) {
                $join->on('test_prices.TestId', '=', 'tests.id');
            })
            ->where('test_prices.TestLocation', '=', $request->TestLocation)
            ->orderBy('test_prices.TestPrice', $request->orderBy)
            ->skip(0)
            ->take($request->Tack)
            ->get();

        return [
            "status" => true,
            "count"  => count($Tests),
            "data"   => $Tests,
        ];
    }

    public function getOrders($id)
    {
        return [
            "status" => true,
            "data"   => Orders::with('Tests')->where('payment_status', 1)->where('user_id', $id)->get()
        ];
    }

    public function change_my_password(Request $request, $id)
    {
        $request->validate([
            'old_password'     => ['required', new MatchOldPassword($id)],
            'new_password'     => ['required'],
            'confirm_password' => ['same:new_password'],
        ]);
        User::find($id)->update(['password' => Hash::make($request->new_password)]);
        return [
            "status" => true,
            "message" =>  "Reset Password Success !"
        ];
    }

    public function cancel_order_reason(Request $request, $order_id)
    {
        Orders::find($order_id)->update([
            'cancel_order_reason' => $request->cancel_order_reason,
            'order_status' => "3"
        ]);
        return [
            "status" => true,
            "message" =>  "Cancle order requested !"
        ];
    }
    public function get_city_master()
    {
        return  Cities::select('*')->groupBy('CityName')->pluck('CityID', 'CityName')->toArray();
    }
    public function get_lab_location($city_id = null)
    {
        if (!is_null($city_id)) {
            return Branch::where('BranchCityId', $city_id)->get()->groupBy('BranchCity');
        }
        return Branch::all()->groupBy('BranchCity');
    }
    public function get_organs()
    {
        $data = Organs::orderBy('order_by')->get();
        $result = [];
        foreach ($data as $key => $row) {
            if (is_null($row->image)) {
                $image = "https://cdn-icons-png.flaticon.com/512/3655/3655592.png";
            } else {
                $image = asset_url($row->image);
            }
            $result[] = [
                "name" => $row->name,
                "image" => $image,
            ];
        }
        return $result;
    }
    public function get_conditions()
    {
        $data = Conditions::orderBy('order_by')->get();
        $result = [];
        foreach ($data as $key => $row) {
            if (is_null($row->image)) {
                $image = "https://cdn-icons-png.flaticon.com/512/3974/3974887.png";
            } else {
                $image = asset_url($row->image);
            }
            $result[] = [
                "name" => $row->name,
                "image" => $image,
            ];
        }
        return $result;
    }
    public function forgot_password(Request $request)
    {
        $customer = User::where('email', $request->email)->first();
        if (!is_null($customer)) {
            Mail::to($customer->email)->send(new ResetPasswordMail($customer,$request->origin));
            return response([
                "status"   => true,
                "customer" => $customer->id,
                "message"  => "Email Verified Success !"
            ]);
        }
        return response([
            "status" => false,
            "message" => "Invalid Email Address !"
        ]);
    }
    public function reset_password(Request $request, $id)
    {
        $request->validate(['new_password' => 'required']);
        $User = User::find(decrypt($id));
        if (!is_null($User)) {
            $User->update(['password' => Hash::make($request->new_password)]);
            return [
                "status"  => true,
                "data"    => $User,
                "message" => "Reset Password Success !"
            ];
        }
        return [
            "status"  => false,
            "data"    => $User,
            "message" => "User Not Found!"
        ];
    }
    public function cart_items($user_id)
    {
        $cart     = Cart::with('Tests', 'Packages')->where(['user_id' => $user_id])->get();
        $tests    = [];
        $packages = [];
        foreach ($cart as $item) {
            if ($item->test_type == 'TEST') {
                $tests[]  = $item->tests;
            } else {
                $packages[]  = $item->packages;
            }
        }
        return array_merge($tests, $packages);
    }
    public function add_to_cart(Request $request)
    {
        Cart::create([
            'user_id'   => $request->user_id,
            'test_id'   => $request->test_id,
            'test_type' => $request->test_type,
        ]);
        return [
            "status"  => true,
            "message" => "Added"
        ];
    }

    public function remove_to_cart(Request $request)
    {
        Cart::where([
            'user_id'   => $request->user_id,
            'test_id'   => $request->test_id,
            'test_type' => $request->test_type,
        ])->delete();
        return [
            "status"  => true,
            "message" => "Removed"
        ];
    }
}
