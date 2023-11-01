<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
class CommonController extends Controller
{   

 
    public static function PostData($first_name,$last_name,$email,$phone,$module){
   $accessKey = 'u$rafcadbc93df2b0aeebff438246559fdf';
   $secretKey = 'd013041fc6d8104d7bba2d699fcb7f5949c72c8c';
    $api_url_base = 'https://api-in21.leadsquared.com/v2/ProspectActivity.svc';
    $url = $api_url_base . '/CreateCustom?accessKey=' . $accessKey . '&secretKey=' . $secretKey;
    $first_name=$first_name??'test';
    $last_name=$last_name??'test';
    $email=$email??'test@gmail.com';
    $phone=$phone??'8903060227';
    $module=$module??'Feedback-b2b for the activity';
    $time=Carbon::now();
$data_string = '{"LeadDetails": [{
"Attribute": "FirstName",
"Value": "'.$first_name.'"},{
"Attribute": "LastName",
"Value": "'.$last_name.'"},{
"Attribute": "EmailAddress",
"Value": "'.$email.'"},{
"Attribute": "Phone","Value": "'.$phone.'"},
{"Attribute": "SearchBy","Value": ""},
{"Attribute": "Source","Value": "Website"},
{"Attribute": "mx_Secondary_Source","Value": "Website - Anandlab.com"},
{"Attribute": "mx_City","Value": ""},
{"Attribute": "mx_State","Value": "Karnataka"},
{"Attribute": "mx_Owner_Group","Value": "NADL"},
{"Attribute": "mx_LIMS_ID","Value": "2"},
{"Attribute": "mx_Zip","Value": ""},
{"Attribute": "Patient Stage","Value": "Open"}],
"Activity": {
"ActivityEvent": 207,
"ActivityNote": "'.$module.'",
"ActivityDateTime": "'.$time.'",
"Fields": [
{
"SchemaName": "Status",
"Value": "Active"}]}}'; 

    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type:application/json',
        'Content-Length:'.strlen($data_string)
        ));
     $response = curl_exec($curl);
     $err = curl_error($curl);
      curl_close($curl);
     
      if($err) {
        return json_decode($err);
      } else {
      return $response;
      }
}

}
