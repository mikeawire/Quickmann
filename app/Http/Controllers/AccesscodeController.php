<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AccessCode;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Str;

class AccesscodeController extends Controller
{
     /**
     * Show all of the users for the application.
     *
     * @return Response
     */

    public function index(){
        $access = DB::select('select * from access_codes');
        return view('staffaccesscode',['access'=>$access]);
        }
        
        
        
        
 public function sendSms($recipient)
{
    $url = 'https://sms.vanso.com/rest/sms/submit/long'; // Replace with your API endpoint
    $username = 'NG.103.0124';
    $password = 'KTp86MTJ';

    $postData = [
        "sms" => [
            "dest" => $recipient,
            "referenceId" => Str::random(10),
            "src" => "ISWTest",
            "text" => "hi testing",
            "unicode" => true
        ],
        "account" => [
            "password" => $password,
            "systemId" => $username
        ]
    ];

   return $response = Http::withBasicAuth($username, $password)
        ->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->post($url, $postData);

    // Get the response body or other details
    $responseBody = $response->body();
    $status = $response->status();

    // Handle the response or return it as needed
}
    
  
}
