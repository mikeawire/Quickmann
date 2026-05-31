<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
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
use App\Models\StaffProfile;
use App\Models\Otps;
use DB;

class Customerslist extends Component
{
	  use WithPagination;
      protected $paginationTheme = 'bootstrap';
	public $search="";

    public function render()
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
         elseif( Auth::user()->staffprofile->role == 'MD' || Auth::user()->staffprofile->role =='CFO' || Auth::user()->staffprofile->role =='CMO'|| Auth::user()->staffprofile->role == 'COO' || Auth::user()->staffprofile->role == 'CD' || Auth::user()->staffprofile->role == 'FDO' || Auth::user()->staffprofile->role == 'AO'  || Auth::user()->staffprofile->role =='TSO' || Auth::user()->staffprofile->role =='SO'
          )

          {



        $count=1;
        $customers =DB::table('users')
        ->join('customer_profiles','users.id','=','customer_profiles.user_id')
        ->select('users.*','customer_profiles.*')
       ->where('users.user_status','active')
        ->Where('customer_profiles.surname', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
        ->orWhere('users.user_status','active')

        ->Where('customer_profiles.first_name', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
        ->orWhere('users.user_status','active')

        ->Where('customer_profiles.othername', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
        ->orWhere('users.user_status','active')

        ->Where('users.phone', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
        ->orWhere('users.user_status','active')

        ->Where('users.email', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
        ->orWhere('users.user_status','active')

        ->Where('customer_profiles.reg_no', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')


         ->orderBy('customer_profiles.surname','ASC')
         ->simplePaginate(100);


        return view('livewire.customerslist')->with(compact('count','customers'));
          }

            elseif( Auth::user()->staffprofile->role =='PM'
          )

          {



        $count=1;

       // $customers = CustomerProfile::where('ea_id',Auth::user()->id)->orderBy('created_at','DESC')->simplePaginate(10);

          $customers =DB::table('users')
        ->join('customer_profiles','users.id','=','customer_profiles.user_id')
        ->select('users.*','customer_profiles.*')
        ->where('users.user_status','active')
        ->where('users.user_type','customer')
         ->Where('customer_profiles.reg_no', 'like', '%'.$this->search.'%')
       ->where('customer_profiles.po_id',Auth::user()->id)
        ->orWhere('users.user_status','active')

        ->Where('customer_profiles.first_name', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.po_id',Auth::user()->id)
        ->orWhere('users.user_status','active')

        ->Where('customer_profiles.othername', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.po_id',Auth::user()->id)
        ->orWhere('users.user_status','active')

        ->Where('users.phone', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.po_id',Auth::user()->id)
        ->orWhere('users.user_status','active')

        ->Where('users.email', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.po_id',Auth::user()->id)
       ->orWhere('users.user_status','active')

        ->Where('customer_profiles.reg_no', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.po_id',Auth::user()->id)
        ->orderBy('customer_profiles.surname','ASC')

        ->simplePaginate(50);


    return view('livewire.customerslist')->with(compact('count','customers'));




          }

              elseif( Auth::user()->staffprofile->role =='EA'
          )

          {



        $count=1;

        //$customers = CustomerProfile::where('ea_id',Auth::user()->id)->simplePaginate(50);


             $customers =DB::table('users')
        ->join('customer_profiles','users.id','=','customer_profiles.user_id')
        ->select('users.*','customer_profiles.*')
      ->where('users.user_status','active')
        ->where('users.user_type','customer')
         ->Where('customer_profiles.reg_no', 'like', '%'.$this->search.'%')
       ->where('customer_profiles.ea_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('customer_profiles.first_name', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.ea_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('customer_profiles.othername', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.ea_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('users.phone', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.ea_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('users.email', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.ea_id',Auth::user()->id)
       ->orWhere('users.user_status','active')
        ->Where('customer_profiles.reg_no', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.ea_id',Auth::user()->id)
        ->orderBy('customer_profiles.surname','ASC')

        ->simplePaginate(50);

    return view('livewire.customerslist')->with(compact('count','customers'));




          }
              elseif( Auth::user()->staffprofile->role =='AHO'
          )

          {



        $count=1;

       // $customers = CustomerProfile::where('aho_id',Auth::user()->id)->simplePaginate(50);

              $customers =DB::table('users')
        ->join('customer_profiles','users.id','=','customer_profiles.user_id')
        ->select('users.*','customer_profiles.*')
        ->where('users.user_status','active')
        ->where('users.user_type','customer')
         ->Where('customer_profiles.reg_no', 'like', '%'.$this->search.'%')
       ->where('customer_profiles.aho_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('customer_profiles.first_name', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.aho_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('customer_profiles.othername', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.aho_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('users.phone', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.aho_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('users.email', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.aho_id',Auth::user()->id)
       ->orWhere('users.user_status','active')
        ->Where('customer_profiles.reg_no', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.aho_id',Auth::user()->id)
        ->orderBy('customer_profiles.surname','ASC')

        ->simplePaginate(50);


    return view('livewire.customerslist')->with(compact('count','customers'));




          }

                 elseif( Auth::user()->staffprofile->role =='DRO'
          )

          {



        $count=1;

        //$customers = CustomerProfile::where('dro_id',Auth::user()->id)->simplePaginate(50);

              $customers =DB::table('users')
        ->join('customer_profiles','users.id','=','customer_profiles.user_id')
        ->select('users.*','customer_profiles.*')
       ->where('users.user_status','active')
        ->where('users.user_type','customer')
         ->Where('customer_profiles.reg_no', 'like', '%'.$this->search.'%')
       ->where('customer_profiles.dro_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('customer_profiles.first_name', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.dro_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('customer_profiles.othername', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.dro_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('users.phone', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.dro_id',Auth::user()->id)
        ->orWhere('users.user_status','active')
        ->Where('users.email', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.dro_id',Auth::user()->id)
       ->orWhere('users.user_status','active')
        ->Where('customer_profiles.reg_no', 'like', '%'.$this->search.'%')
        ->where('users.user_type','customer')
         ->where('customer_profiles.dro_id',Auth::user()->id)
        ->orderBy('customer_profiles.surname','ASC')

        ->simplePaginate(50);


    return view('livewire.customerslist')->with(compact('count','customers'));




          }

        else
        {
           return redirect('/home');
        }




    }
}
