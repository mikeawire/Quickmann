<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CustomerProperty;
use App\Models\StaffProfile;
use App\Models\Plot;
use App\User;
use App\Models\Product;
use App\Models\PlotType;
use Paystack;
class CustomerPropertyController extends Controller
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
        $count =1;
        $customerproperties = CustomerProperty::where('customer_id',Auth::user()->id)->where('property_status','!=','revoked')->simplePaginate(10);
        return view('Customer/product/index')->with(compact('customerproperties','count'));
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
        $cp=CustomerProperty::find($id);
        $dros = StaffProfile::where('reg_no',$cp->dro_reg_no)->get();

      
        $plot =Plot::find($cp->plot_id);
        $product =Product::find($plot->product_id);
        $brand = PlotType::find($plot->plot_type_id);
       
     

        return view('Customer/product/show')->with(compact('cp','dros','plot','product','brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function droprofile($id)
    {
        $staff = User::findOrFail($id);
        return view('Customer/product/dro')->with(compact('staff'));
    }

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
