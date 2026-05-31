<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerProfileController extends Controller
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
     
        if(Auth::user()->user_type=='customer' &&  Auth::user()->customerprofile->profile_status=='complete' )

        return view('Customer/profile/index');
        else
        return redirect('/home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    //change password
        
    return view('Customer/profile/changepassword');
    }

    public function editpersonalinfo()
    {
    
        return view('Customer/profile/editpersonalinfo');
    }

    public function editcontactinfo()
    {
    
        return view('Customer/profile/editcontactinfo');
    }


    public function editnextkininfo()
    {
    
        return view('Customer/profile/editnextkininfo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);   
        Auth::user()->password =Hash::make($request->password);
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
        //
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
        if($request->type == 'step_one')
        {

            $request->validate([
                'gender' => ['required'],
                'marital_status' => ['required'],
               
            ]);
           
            Auth::user()->customerprofile->othername =$request->othername;
            Auth::user()->customerprofile->dob =$request->dob;
            
            Auth::user()->customerprofile->gender =$request->gender;
            Auth::user()->customerprofile->marital_status =$request->marital_status;
         
            Auth::user()->customerprofile->save();
            return back()->with('success_msg','Updated Successful');
            

        }
        elseif($request->type == 'step_two')
        {
        
        $request->validate([
            'email' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'address' => ['required'],
           
        ]);

        Auth::user()->customerprofile->city =$request->city;
        Auth::user()->customerprofile->state =$request->state;
        Auth::user()->customerprofile->address =$request->address;
    
        Auth::user()->customerprofile->save();
    Auth::user()->email =$request->email;
     Auth::user()->save();
        return back()->with('success_msg','Updated Successful');

       
        }
    
        elseif($request->type == 'step_three')
        {
            $request->validate([
                'address' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'names' => ['required'],
                'email' => ['required','email','string'],
                'phone_number' => ['required',new phonenumber],
                'address' => ['required'],
                'relationship' => ['required'],
                'gender' => ['required'],
               
            ]);
    
            Auth::user()->customerprofile->next_of_kin_city =$request->city;
            Auth::user()->customerprofile->next_of_kin_state =$request->state;
            Auth::user()->customerprofile->next_of_kin_address =$request->address;
            Auth::user()->customerprofile->next_of_kin_name =$request->names;
            Auth::user()->customerprofile->next_of_kin_email =$request->email;
            Auth::user()->customerprofile->next_of_kin_phone =$request->phone_number;
            Auth::user()->customerprofile->next_of_kin_relationship =$request->relationship;
            Auth::user()->customerprofile->next_of_kin_gender =$request->gender;
         
            Auth::user()->customerprofile->save();
            
            return back()->with('success_msg','Updated Successful');

       
        }
        elseif($request->type == 'step_four')
        {
       
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
   
       ]);
       
         
       $image = time().'.'.$request->profile_photo->getClientOriginalExtension();
   
       $request->profile_photo->move(public_path('/images'), $image);
       Auth::user()->customerprofile->profile_photo =$image;
      

       Auth::user()->customerprofile->save();
     
       $image = Session::put('image',$image);
       
       return back()->with('success_msg','Updated Successful');
        }
        elseif($request->type == 'change')
        {
         
            $image = Session::forget('image');

               
       return redirect('/dashboard');
        }
        elseif($request->type == 'save')
        {
         
            $image = Session::forget('image');

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
        //
    }
}
