<?php

namespace App\Http\Controllers;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use App\User;
use App\Models\CustomerProfile;
use App\Models\CustomerProperty;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Branch;
use Illuminate\Validation\Rule;

use App\Models\StaffProfile;
use App\Models\Otp;
use DB;
class CustomerController extends Controller
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
       return view('Staff/Customer/Customer/index');


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
        $customer =User::find($id);
        return view('Staff/Customer/Customer/show')->with(compact('customer'));
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
         elseif( Auth::user()->staffprofile->role == 'MD' || Auth::user()->staffprofile->role =='CFO' || Auth::user()->staffprofile->role =='CMO'|| Auth::user()->staffprofile->role == 'COO' || Auth::user()->staffprofile->role == 'CD' || Auth::user()->staffprofile->role == 'FDO'
          )

          {



             $customer= User::findOrFail($id);
$branch=Branch::findOrfail($customer->customerprofile->branch_id);
        $pms = StaffProfile::where('role','PM')->where('status','active')->get();
$dros = StaffProfile::orderBy('created_at','DESC')->where('status','active')->get();

$eas = StaffProfile::where('status','active')->get();
$branches =Branch::all();
$dro =User::find($customer->customerprofile->dro_id);
$pm =User::find($customer->customerprofile->po_id);
$ahos = StaffProfile::where('role','AHO')->where('status','active')->get();
if($customer->customerprofile->aho_id !=null)
{
 $aho =User::find($customer->customerprofile->aho_id);
}
else
{
    $aho='';
}

if($customer->customerprofile->ea_id !=null)
{
$ea =User::find($customer->customerprofile->ea_id);
}
else
{
    $ea='';
}



    return view('Staff/Customer/Customer/edit')->with(compact('pms','dros','branches','ea','customer','branch','dro','eas','pm','ahos','aho'));
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
           $request->validate([
                'gender' => ['required'],
                'marital_status' => ['required'],
                'surname' => ['required'],
                'first_name' => ['required'],

                'dob' => ['required'],
'phone' => ['required', Rule::unique('users', 'phone')->ignore($id), new PhoneNumber],

                  'designated_state' => ['required'],
                    'dro' => ['required'],
                      'pm' => ['required'],

                        'branch' => ['required'],


            ]);
//dd($request->phone);
           $customer =User::findOrfail($id);
            $customer->phone =$request->phone;
                 $customer->email =$request->email;
                 $customer->save();
            $customer->customerprofile->surname =$request->surname;
           $customer->customerprofile->first_name =$request->first_name;
            $customer->customerprofile->othername =$request->othername;
             $customer->customerprofile->marital_status =$request->marital_status;
              $customer->customerprofile->gender =$request->gender;
               $customer->customerprofile->dob =$request->dob;
                $customer->customerprofile->designated_state =$request->designated_state;
                 $customer->customerprofile->dro_id =$request->dro;

                     $customer->customerprofile->po_id =$request->pm;
                 $customer->customerprofile->aho_id = $request->aho;
                $customer->customerprofile->ea_id = $request->ea;
                   $customer->customerprofile->branch_id =$request->branch;
                    $customer->customerprofile->state =$request->state;
                     $customer->customerprofile->city =$request->city;
                      $customer->customerprofile->address =$request->address;
                       $customer->customerprofile->save();


                       return back()->with('success_msg','Updated Successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(Auth::user()->staffprofile->role=='CMO' || Auth::user()->staffprofile->role =='MD')
        {

            $props = CustomerProperty::where('customer_id',$id)->get();
            if($props->count() > 0)
            {
                $user= User::find($id);
                $user->user_status='terminated';
                $user->save();

               return back()->with('success_msg','Customer Account terminated Successful');
            }
            else
            {

          DB::statement('SET FOREIGN_KEY_CHECKS=0;');


          $user= User::find($id);
          $customer=$user->customerprofile;

           $customer->delete();
            $user->delete();
          DB::statement('SET FOREIGN_KEY_CHECKS=1;');

               return back()->with('success_msg','Customer Deleted Successful');
            }
        }


    }
}
