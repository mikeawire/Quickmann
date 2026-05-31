<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\Models\StaffProfile;
use Illuminate\Support\Facades\Auth;
class PendingStaffRegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
             if(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->surname == null
      &&  Auth::user()->staffprofile->first_name == null)
        {
           return view('Staff/staff/CompleteProfile/create');
        }
        elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->address == null
        &&  Auth::user()->staffprofile->state == null &&   Auth::user()->staffprofile->city == null)
          {
             return view('Staff/staff/CompleteProfile/step2');
          }
          elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->profile_photo == null
       )
          {
             return view('Staff/staff/CompleteProfile/step3');
          }
          elseif( Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='HRM'
          )
          
          {
              
             $count=1;
        $staffs = StaffProfile::where('status','inactive')->SimplePaginate();
        return view('Staff/staff/pendingReg/index')->with(compact('staffs','count'));
             
          }
    
        else
        {
           return redirect('/home');
        }
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         if(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->surname == null
      &&  Auth::user()->staffprofile->first_name == null)
        {
           return view('Staff/staff/CompleteProfile/create');
        }
        elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->address == null
        &&  Auth::user()->staffprofile->state == null &&   Auth::user()->staffprofile->city == null)
          {
             return view('Staff/staff/CompleteProfile/step2');
          }
          elseif(Auth::user()->staffprofile->profile_status == 'incomplete' && Auth::user()->staffprofile->profile_photo == null
       )
          {
             return view('Staff/staff/CompleteProfile/step3');
          }
          elseif( Auth::user()->staffprofile->role == 'DRO' && Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='HRM'
          )
          
          {
              
          $staff= User::findOrFail($id);
        return view('Staff/staff/pendingReg/show')->with(compact('staff'));
             
          }
    
        else
        {
           return redirect('/home');
        }
     

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $staff= StaffProfile::findOrFail($id);
        $staff->status='active';
        $staff->save();
        return back()->with('success_msg','Staff Approved Successful');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
