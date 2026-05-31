<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Otps;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OtpController extends Controller
{

     /**
     * Show all of the users for the application.
     *
     * @return Response
     */

    public function index(){

        $otps = DB::select('select * from otps');
        return view('otpview',['otps'=>$otps]);
        }
}
