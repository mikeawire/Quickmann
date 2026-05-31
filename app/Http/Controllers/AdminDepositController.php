<?php

namespace App\Http\Controllers;
use App\Models\Deposit;
use Illuminate\Http\Request;
use App\User;
use App\Models\Plot;
use App\Models\PlotType;
use App\Models\Product;
use App\Models\CustomerProperty;
class AdminDepositController extends Controller
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
        $count=1;
        $deposits = Deposit::where('payment_type','!=','topup')->orderBy('created_at','DESC')->simplePaginate();
        return view('Staff/Deposit/index')->with(compact('deposits','count'));
    }
    
    
       public function topup()
    {
        $count=1;
        $deposits = Deposit::where('payment_type','topup')->orderBy('created_at','DESC')->simplePaginate();
        return view('Staff/Deposit/topup')->with(compact('deposits','count'));
    }
    
    
    
    //get arriers
    
    
    
      public function arriers()
    {
        
   $count=1;
 $arriers= CustomerProperty::where('payment_status','incomplete')->simplePaginate();
       $arriercount= CustomerProperty::where('payment_status','incomplete')->get();
        
        return view('Staff/Deposit/arriers')->with(compact('arriers','count','arriercount'));
    }

    public function ajax_arriers(Request $request)
    {
        
      

   $draw = $request->get('draw');
   $start = $request->get("start");
   $rowperpage = $request->get("length"); // Rows display per page

   $columnIndex_arr = $request->get('order');
   $columnName_arr = $request->get('columns');
   $order_arr = $request->get('order');
   $search_arr = $request->get('search');

   $columnIndex = $columnIndex_arr[0]['column']; // Column index
   $columnName = $columnName_arr[$columnIndex]['data']; // Column name
   if($columnName =="id")
   {
    $columnName="customer_properties.id";
   }

   if($columnName =="name")
   {
    $columnName="customer_profiles.surname";
   }
   if($columnName =="location name")
   {
    $columnName="products.location_name";
   }

  

   if($columnName =="amount")
   {
    $columnName="customer_properties.unpaid_balance";
   }

   if($columnName =="Property Price")
   {
    $columnName="customer_properties.property_price";
   }

   if($columnName =="plot_id")
   {
    $columnName="customer_properties.plot_id";
   }

   
   if($columnName =="button")
   {
    $columnName="customer_properties.id";
   }


 

   $columnSortOrder = $order_arr[0]['dir']; // asc or desc
   $searchValue = $search_arr['value']; // Search value
   //$searchValue = explode(' ', $searchValue);

   // Total records
 $totalRecords = CustomerProperty::where('payment_status','incomplete')->select('count(*) as allcount')->count();
  
       
   $totalRecordswithFilter = CustomerProperty::join('users','users.id','customer_properties.customer_id')->join('customer_profiles','customer_profiles.user_id','users.id')->join('plots','plots.id','customer_properties.plot_id')->join('products','plots.product_id','products.id')->select('count(*) as allcount')->Where(function ($query) use($searchValue) {
       
          $query->orWhere('customer_profiles.surname', 'like', '%' .$searchValue . '%')
          ->orWhere('customer_profiles.first_name', 'like', '%' .$searchValue . '%')->orWhere('products.location_name', 'like', '%' .$searchValue . '%')
          ->orWhere('customer_profiles.othername', 'like', '%' .$searchValue . '%')
          ->orWhere('customer_properties.created_at', 'like', '%' .$searchValue . '%')
          ->orWhere('customer_properties.unpaid_balance', 'like', '%' .$searchValue . '%')
          ->orWhere('customer_properties.property_price', 'like', '%' .$searchValue . '%')
          ->orWhere('plots.Plot_id', 'like', '%' .$searchValue . '%');
           })->where('customer_properties.payment_status','incomplete')->count();
  
   

   // Fetch records
   $records =CustomerProperty::join('users','users.id','customer_properties.customer_id')->join('customer_profiles','customer_profiles.user_id','users.id')->join('plots','plots.id','customer_properties.plot_id')->join('products','plots.product_id','products.id')->select('count(*) as allcount')->Where(function ($query) use($searchValue) {
       
    $query->orWhere('customer_profiles.surname', 'like', '%' .$searchValue . '%')
    ->orWhere('customer_profiles.first_name', 'like', '%' .$searchValue . '%')->orWhere('products.location_name', 'like', '%' .$searchValue . '%')
    ->orWhere('customer_profiles.othername', 'like', '%' .$searchValue . '%')
    ->orWhere('customer_properties.created_at', 'like', '%' .$searchValue . '%')
    ->orWhere('customer_properties.unpaid_balance', 'like', '%' .$searchValue . '%')
    ->orWhere('customer_properties.property_price', 'like', '%' .$searchValue . '%')
    ->orWhere('plots.Plot_id', 'like', '%' .$searchValue . '%');
     })->where('customer_properties.payment_status','incomplete')->select('customer_properties.*','plots.*','products.*','customer_profiles.*','customer_properties.id as p_id')
       ->skip($start)
       ->take($rowperpage)
       ->orderBy($columnName,$columnSortOrder)
       ->get();
   

   $data_arr = array();
   $sno = $start+1;
   foreach($records as $record){

       $name =$record->surname.' '.$record->first_name.' '.$record->othername;
       $name=ucwords($name);

       $email = $record->email;
       $button='<div class="d-flex"><form action="'.route("arriers.show",$record->p_id) .'" method="POST">
       <input name="_method" type="hidden" value="GET">
                                           '.csrf_field().'
<button onclick="return confirm("Are you sure want to view Transaction Details")" 
                               class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-eye"></i></button>
            </form>
         </div>';               
       $data_arr[] = array(
           "id" => '<div class="d-flex">'.$sno++.' </div>',
           "name" => $name,
           "location_name"=>ucwords($record->location_name),
           "plot_id"=>$record->Plot_id,
           "amount"=>$record->unpaid_balance,
           "property_price"=>$record->property_price,
           "button" =>$button,
       );
   }

   $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecords,
       "iTotalDisplayRecords" => $totalRecordswithFilter,
       "aaData" => $data_arr
   ); 

   echo json_encode($response);
   exit;


    }
    
      public function arriers_show($id)
    {
        
  
 $cp= CustomerProperty::find($id);
 $customer=User::find($cp->customer_id);


        $plot =Plot::find($cp->plot_id);
        $product =Product::find($plot->product_id);
        $brand = PlotType::find($plot->plot_type_id);
       
        
        return view('Staff/Deposit/arriers_show')->with(compact('cp','product','plot','brand','customer'));
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
          $deposit= Deposit::findOrFail($id);
   

        $plot =Plot::find($deposit->plot_id);
        $product =Product::find($plot->product_id ??'');
        $brand = PlotType::find($plot->plot_type_id ?? '');
       $customer =User::find($deposit->customer_id);
           $cp =CustomerProperty::find($deposit->customer_property_id);
       
        
        return view('Staff/Deposit/show')->with(compact('deposit','plot','brand','product','customer','cp'));
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
