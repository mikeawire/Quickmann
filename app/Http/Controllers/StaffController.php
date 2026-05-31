<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\StaffProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Branch;
use DB;
use Illuminate\Support\Facades\Auth;
class StaffController extends Controller
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
          elseif(Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='HRM' ||  Auth::user()->staffprofile->role == 'COO' ||  Auth::user()->staffprofile->role =='CFO'
          )
          
          {
              
                 $count=1;
        $staffs = User::where('user_type','staff')->simplePaginate(10);

        return view('Staff/staff/StaffList/index')->with(compact('staffs','count')); 
             
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
    //change  Staff Personal password
    public function store(Request $request)
    {
        $request->validate([
           
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ]);
  Auth::user()->password = Hash::make($request->password);
  Auth::user()->save();

  return back()->with('success_msg','Password Updated Successful');
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
          elseif(Auth::user()->staffprofile->designated_state==null
          )
          
          
             {
                return view('Staff/staff/CompleteProfile/step4');
             }
             
              elseif( Auth::user()->staffprofile->status == 'inactive'
          )
          
          
             {
                return view('Staff/staff/inactive/index');
             }
        
        
           elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='HRM' ||  Auth::user()->staffprofile->role == 'COO' ||  Auth::user()->staffprofile->role =='CFO'
          )
          
          {
              
            $staff= User::findOrFail($id);
        return view('Staff/staff/StaffList/show')->with(compact('staff'));
             
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
              
      $staff= User::findOrFail($id);
      $branch =Branch::find($staff->staffprofile->branch_id);
      $branches=branch::all();
        return view('Staff/staff/StaffList/edit')->with(compact('staff','branch','branches'));
             
          }
    
        else
        {
           return redirect('/home');
        }
      
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
      
        $staff=StaffProfile::find($id);

           $staff->designated_state =$request->state;
            $staff->branch_id =$request->branch;
            $staff->role =$request->position;
            $staff->save();

            if($staff->status == 'inactive')
            {
                return redirect('pendingstaffreg/'.$staff->user_id)->with('success_msg','Updated Successful');
            }
            else {
                return back()->with('success_msg','Updated Successful');
            }
         

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->staffprofile->role=='HRM')
        {
            
     
        $staff = StaffProfile::find($id);
        if($staff->user_id == Auth::user()->id)
        {
            return back()->with('warning_msg','Cannot Delete Your Self');
        }
        elseif($staff->role=='MD')
        {
             return back()->with('warning_msg','You Do not have the capacity to delete Managing Director, only managing director can do so');
        }
        
         elseif($staff->role=='HRM' && $staff->status ='active')
        {
             return back()->with('warning_msg','You Do not have the capacity to delete any active Human Relationship Manager, only managing director can do so');
        }
        else
        {
            $staff = Staffprofile::find($id);
          $user= User::find($staff->user_id);
           DB::statement('SET FOREIGN_KEY_CHECKS=0;');
           $staff->delete();
          $user->delete();
          DB::statement('SET FOREIGN_KEY_CHECKS=1;');
               return back()->with('success_msg','Staff Deleted Successful'); 
        }
    }
    elseif(Auth::user()->staffprofile->role=='MD')
    {
           $staff = StaffProfile::find($id);
          $user= User::find($staff->user_id);
          DB::statement('SET FOREIGN_KEY_CHECKS=0;');
           $staff->delete();
          $user->delete();
          DB::statement('SET FOREIGN_KEY_CHECKS=1;');
          
               return back()->with('success_msg','Staff Deleted Successful');
    }
    
    
}

}
