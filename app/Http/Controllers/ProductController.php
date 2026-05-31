<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Plot;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='HRM' ||  Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='CFO' ||  Auth::user()->staffprofile->role =='FDO' ||  Auth::user()->staffprofile->role =='CD'  
          )
          
          {
              
     
        $count=1;
        $products=Product::orderBy('created_at','Desc')->simplePaginate(20);
        return view('/Staff/Property/product/index')->with(compact('products','count'));
             
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
         elseif( Auth::user()->staffprofile->role == 'MD' || Auth::user()->staffprofile->role =='TSO' ||
           Auth::user()->staffprofile->role =='SO'
          )
          
          {
              
     
          return view('/Staff/Property/product/create');
             
          }
    
        else
        {
           return redirect('/home');
        }   
      
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
           
            'location_name' => 'required',
            'purpose' => 'required',
            'state' => 'required',
            'town' => 'required',
            'address' => 'required',
          
            
        ]);
        $product =new Product;
        $product->location_name =$request->location_name;
        $product->purpose =$request->purpose;
        $product->state =$request->state;
        $product->town =$request->town;
        $product->address =$request->address;
        $product->save();
        return back()->with('success_msg','Added Successful');

        
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
         elseif( Auth::user()->staffprofile->role == 'MD' ||  Auth::user()->staffprofile->role =='HRM' ||  Auth::user()->staffprofile->role =='CMO' ||  Auth::user()->staffprofile->role =='COO' ||  Auth::user()->staffprofile->role =='CFO'||  Auth::user()->staffprofile->role =='FDO' ||  Auth::user()->staffprofile->role =='CD'
          )
          
          {
              
     
       $count=1;
        $plots =Plot::where('product_id',$id)->where('status','unsold')->orderBy('created_at','DESC')->simplePaginate(10);
        return view('/Staff/Property/Plot/index')->with(compact('plots','count','id'));
             
          }
          
          elseif( Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO'
          )
          
          {
              
     
       $count=1;
        $plots =Plot::where('product_id',$id)->orderBy('created_at','DESC')->simplePaginate(10);
        return view('/Staff/Property/Plot/index')->with(compact('plots','count','id'));
             
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
         elseif( Auth::user()->staffprofile->role == 'MD' || Auth::user()->staffprofile->role =='TSO' ||  Auth::user()->staffprofile->role =='SO'
          )
          
          {
              
       $product=Product::find($id);
        return view('/Staff/Property/product/edit')->with(compact('product'));
             
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
           
            'location_name' => 'required',
            'purpose' => 'required',
            'state' => 'required',
            'town' => 'required',
            'address' => 'required',
          
            
        ]);
        $product =Product::find($id);
        $product->location_name =$request->location_name;
        $product->purpose =$request->purpose;
        $product->state =$request->state;
        $product->town =$request->town;
        $product->address =$request->address;
        $product->save();
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
    
        Product::findOrFail($id)->delete();
        return back()->with('success_msg','Deleted Successful');
    }
}
