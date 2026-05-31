<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plot;
use App\Models\PlotType;
use App\Models\Product;
use Session;
use DB;
class ProductSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user())
        {
            return view('findproperty/newindex');
        }
        else
        {
            return view('findproperty/index');
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
        $request->validate([
           
            'initial_payment' => 'required',
            'monthly_payment' => 'required',
            'state' => 'required',
            'price_range' => 'required',
            'mode_of_payment' => 'required',
          
            
        ]);

        
$count=1;
        $initial_payment =Session::put('initial_payment',$request->initial_payment);
        $monthly_payment =Session::put('monthly_payment',$request->monthly_payment);
        $mode_of_payment =Session::put('mode_of_payment',$request->mode_of_payment);
        $price_range =Session::put('price_range',$request->price_range);
        $state =Session::put('state',$request->state);
 
        if($request->price_range == 'a')
        {
            $plots = Plot::where('status','unsold')->where('price','<=', 500000)->distinct()->select('product_id')->simplePaginate();
         

                return view('/findproperty/result')->with(compact('count','plots'));
            
          
        }
        elseif($request->price_range == 'b')

        {
            $plots = Plot::where('status','unsold')->where('price','>=', 500000)->where('price','<=', 1000000)->distinct()->select('product_id')->simplePaginate();
            
              

                return view('/findproperty/result')->with(compact('count','plots'));
            
        
        }

        elseif($request->price_range == 'c')

        {
            $plots = Plot::where('status','unsold')->where('price','>=', 1000000)->where('price','<=', 1500000)->distinct()->select('product_id')->simplePaginate();
           
             
            

                return view('/findproperty/result')->with(compact('count','plots'));
        
        
        }
        elseif($request->price_range == 'd')

        {
            $plots = Plot::where('status','unsold')->where('price','>=', 1500000)->where('price','<=', 3000000)->distinct()->select('product_id')->simplePaginate();
           
               
             

                return view('/findproperty/result')->with(compact('count','plots'));
     
        
        }
        elseif($request->price_range == 'e')

        {
            $plots = Plot::where('status','unsold')->where('price','>=', 3000000)->distinct()->select('product_id')->simplePaginate();
        

                return view('/findproperty/result')->with(compact('count','plots'));
     
        }

        elseif($request->price_range == 'f')

        {
            $plots = Plot::where('status','unsold')->distinct()->select('product_id')->simplePaginate();
         

                return view('/findproperty/result')->with(compact('count','plots'));
       
        }
    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     
$count=1;

        if(Session::get('price_range') =='a')
{
  $plots=DB::table('plots')->where('product_id',$id)->where('status','unsold')->where('price','<=', 500000)->simplePaginate();  
}
elseif(Session::get('price_range') =='b')
{
  $plots=DB::table('plots')->where('product_id',$id)->where('status','unsold')->where('price','>=', 500000)->where('price','<=', 1000000)->simplePaginate();  
}
elseif(Session::get('price_range') =='c')
{
  $plots=DB::table('plots')->where('product_id',$id)->where('status','unsold')->where('price','>=', 1000000)->where('price','<=', 1500000)->simplePaginate();  
}
elseif(Session::get('price_range') =='d')
{
  $plots=DB::table('plots')->where('product_id',$id)->where('status','unsold')->where('price','>=', 1500000)->where('price','<=', 3000000)->simplePaginate();  
}
elseif(Session::get('price_range') =='e')
{
  $plots=DB::table('plots')->where('product_id',$id)->where('status','unsold')->where('price','>=', 3000000)->simplePaginate();  
}
elseif(Session::get('price_range') =='f')
{
  $plots=DB::table('plots')->where('product_id',$id)->where('status','unsold')->simplePaginate();  
}

 return view('/findproperty/show')->with(compact('count','plots'));
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
        //
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
