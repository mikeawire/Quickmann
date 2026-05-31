@extends('adminlte::page')

@section('title', 'Staff Dashoard')
@section('css')
 @laravelPWA
<link rel="stylesheet" type="text/css" href="/css/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<style type="text/css">
	.icon
	{
		font-size: 24px;
	}
</style>
@stop


@section('content')

<!--MD-->
@if(Auth::user()->staffprofile->role =='MD')
<!--query all MD statistics-->
@php
{{

 $customers =DB::table('users')->join('customer_profiles','users.id','=','customer_profiles.user_id')->where('users.user_status','active')->where('users.user_type','customer')->count();
$staff=DB::table('users')->where('user_type','staff')->get();
$md =DB::table('staff_profiles')->where('role','MD')->get();
$hrm =DB::table('staff_profiles')->where('role','HRM')->get();
$cmo =DB::table('staff_profiles')->where('role','CMO')->get();
$dro=DB::table('staff_profiles')->where('role','DRO')->get();
$pm =DB::table('staff_profiles')->where('role','PM')->get();
$bdo =DB::table('staff_profiles')->where('role','BDO')->get();
$bdm =DB::table('staff_profiles')->where('role','BDM')->get();
$hbdm =DB::table('staff_profiles')->where('role','HBDM')->get();
$coo =DB::table('staff_profiles')->where('role','COO')->get();
$cfo =DB::table('staff_profiles')->where('role','CFO')->get();
$tso =DB::table('staff_profiles')->where('role','TSO')->get();
$so =DB::table('staff_profiles')->where('role','SO')->get();
$cd =DB::table('staff_profiles')->where('role','CD')->get();
$fdo =DB::table('staff_profiles')->where('role','FDO')->get();
$oa =DB::table('staff_profiles')->where('role','OA')->get();
$ea =DB::table('staff_profiles')->where('role','EA')->get();
$aho =DB::table('staff_profiles')->where('role','AHO')->get();
$abdm =DB::table('staff_profiles')->where('role','ABDM')->get();
$abdo =DB::table('staff_profiles')->where('role','ABDO')->get();
$hor =DB::table('staff_profiles')->where('role','HOR')->get();
$ao =DB::table('staff_profiles')->where('role','AO')->get();
$branches =DB::table('branches')->get();
$brands =DB::table('plot_types')->get();
$products =DB::table('products')->get();
$stocks =DB::table('plots')->where('status','unsold')->get();
$puis =DB::table('plots')->where('status','pending')->get();
$solds =DB::table('plots')->where('status','sold')->get();
$pstaffs =DB::table('staff_profiles')->where('status','inactive')->get();
$date =date('Y-m-d');

}}

@endphp

<div class="row">

<div class="col-lg-2 col-sm-4">
<div class="card bg-info text-center p-2">
<a href="/customer">	<h6>Customers</h6>

	<i class="fa fa-users icon"></i>

	<p class="mt-lg-4">{{$customers ?? 0}}</p>
	</a>

</div>
</div>

<div class="col-lg-2 col-sm-4">
<div class="card bg-warning text-center p-2">
<a href="/pendingstaffreg">	<h6>Pending Staff</h6>
	<i class="fa fa-users icon"></i>
	<p class="mt-1">{{$pstaffs->count()}}</p></a>

</div>
</div>








<div class="col-lg-2 col-sm-4">
<div class="card bg-info text-center p-2">
<a href="/branch"	><h6>Branches</h6>
	<i class="fa fa-tag icon"></i>
	<p class="mt-lg-4">{{$branches->count()}}</p>
	</a>

</div>
</div>

<div class="col-lg-2 col-sm-4">
<div class="card bg-success text-center p-2">
<a href="/package">	<h6>Brands</h6>
	<i class="fa fa-list icon"></i>
	<p class="mt-lg-4">{{$brands->count()}}</p>
	</a>

</div>
</div>
<div class="col-lg-2 col-sm-4">
<div class="card bg-light text-center p-2">
<a href="/product">	<h6>Product Location</h6>
	<i class="fa fa-map icon"></i>
	<p class="mt-lg-4">{{$products->count()}}</p></a>

</div>
</div>
<div class="col-lg-2 col-sm-4">
<div class="card bg-primary text-center p-2">
<a href="/product">	<h6>Stock</h6>
	<i class="fa fa-cart-plus icon"></i>
	<p class="mt-lg-4">{{$stocks->count()}}</p></a>

</div>
</div>

<div class="col-lg-2 col-sm-4">
<div class="card bg-warning text-center p-2">
<a href="/installmentsales">	<h6>Under Installment</h6>
	<i class="fa fa-shopping-cart  icon"></i>
	<p class="mt-lg-4">{{$puis->count()}}</p></a>

</div>
</div>
<div class="col-lg-2 col-sm-4">
<div class="card bg-success text-center p-2">
<a href="/sales">	<h6>Sold Out</h6>
	<i class="fa fa-shopping-cart  icon"></i>
	<p class="mt-lg-4">{{$solds->count()}}</p></a>

</div>
</div>

        <input type="hidden" id="acc" value="{{$arriers->sum('amount_due')}}" name="acc">
         <input type="hidden" id="cre" value="{{$deposits->sum('amount')}}" name="cre">
          <input type="hidden" id="edi" value="{{$adv->sum('amount')}}" name="edi">
           <input type="hidden" id="de" value="{{$defaulters->sum('amount_due')}}" name="edi">
@php
{{

$deposits =$deposits->sum('amount');
if(strlen($deposits) < 7 )
{

$deposits =number_format($deposits,2);
}
elseif(strlen($deposits) >=7 )
{
$deposits = $deposits/1000000;
$deposits =number_format($deposits,2).'M';
}
elseif(strlen($deposits) >=10 )
{
$deposits = $deposits/1000000000;
$deposits =number_format($deposits,2).'B';
}
elseif(strlen($deposits) >=13 )
{
$deposits = $deposits/1000000000000;
$deposits =number_format($deposits,2).'T';
}


$arriers =$arriers->sum('amount_due');
if(strlen($arriers) < 7 )
{

$arriers =number_format($arriers,2);
}
elseif(strlen($arriers) >=7 )
{
$arriers = $arriers/1000000;
$arriers =number_format($arriers,2).'M';
}
elseif(strlen($arriers) >=10 )
{
$arriers = $arriers/1000000000;
$arriers =$arriers.'B';
}
elseif(strlen($arriers) >=13 )
{
$arriers = $arriers/1000000000000;
$arriers =number_format($arriers,2).'T';
}


$adv =$adv->sum('amount');
if(strlen($adv) < 7 )
{

$adv =number_format($adv,2);
}
elseif(strlen($adv) >=7 )
{
$adv = $adv/1000000;
$adv =number_format($adv,2).'M';
}
elseif(strlen($adv) >=10 )
{
$adv = $adv/1000000000;
$adv =number_format($adv,2).'B';
}
elseif(strlen($adv) >=13 )
{
$adv = $adv/1000000000000;
$adv =number_format($adv,2).'T';
}

}}
@endphp

<div class="col-lg-2 col-sm-4">
<div class="card bg-light text-center p-2">
	<a href="/deposittxn">	<h6>Current  Deposit</h6>
	<i class="fa fa-credit-card  icon"></i>
	<p class="mt-lg-4">&#8358;{{$deposits}}</p></a>

</div>
</div>

<div class="col-lg-2 col-sm-4">
<div class="card bg-danger text-center p-2">
	<a href="/defaulters"><h6> Defaulters</h6>
	<i class="fa fa-users  icon"></i>
	<p class="mt-lg-4">{{$defaulters->count()}}</p></a>

</div>
</div>
<div class="col-lg-2 col-sm-4">
<div class="card bg-info text-center p-2">
	<a href="/">	<h6>Advance Payment</h6>
	<i class="fa fa-credit-card   icon"></i>
	<p class="mt-lg-4">&#8358;{{$adv}}</p></a>

</div>
</div>
<div class="col-lg-2 col-sm-4">
<div class="card bg-danger text-center p-2">
	<a href="/arriers">	<h6>Outstanding Balance</h6>
	<i class="fa fa-credit-card  icon"></i>
	<p class="">&#8358;{{$arriers}}</p></a>

</div>
</div>
@php
$wallet=\App\Models\CustomerProfile::sum('wallet_balance');
$active_investment=\App\Investment::where('status','in progress')->sum('amount');
$liq_investment=\App\Investment::where('status','liquidation requested')->count();

$pen_with=\App\Withdrawal::where('status','pending')->sum('amount');
$total_with=\App\Withdrawal::sum('amount');
$topup=\App\Models\Deposit::where('status','success')->where('payment_type','topup')->sum('amount');
@endphp

<div class="col-lg-2 col-sm-4">
<div class="card bg-primary text-center p-2">
	<a href="#">	<h6>Wallet Balance</h6>
	<i class="fa fa-credit-card  icon"></i>
	<p class="">&#8358;{{numberKFormat($wallet)}}</p></a>

</div>
</div>

<div class="col-lg-2 col-sm-4">
<div class="card bg-info text-center p-2">
	<a href="#">	<h6>Total Topup</h6>
	<i class="fa fa-credit-card  icon"></i>
	<p class="">&#8358;{{numberKFormat($topup)}}</p></a>

</div>
</div>

<div class="col-lg-2 col-sm-4">
<div class="card bg-success text-center p-2">
	<a href="/investments">	<h6>Active Investment</h6>
	<i class="fa fa-credit-card  icon"></i>
	<p class="">&#8358;{{numberKFormat($active_investment)}}</p></a>

</div>
</div>


<div class="col-lg-2 col-sm-4">
<div class="card bg-light text-center p-2">
	<a href="/liquidation-request">	<h6>Liquidation Request</h6>
	<i class="fa fa-list-alt  icon"></i>
	<p class="">{{$liq_investment}}</p></a>

</div>
</div>
<div class="col-lg-2 col-sm-4">
<div class="card bg-warning text-center p-2">
	<a href="/withdrawals">	<h6>Pending Withdrawal</h6>
		<i class="fa fa-credit-card  icon"></i>
	<p class="">&#8358;{{numberKFormat($pen_with)}}</p></a>

</div>
</div>
<div class="col-lg-2 col-sm-4">
<div class="card bg-danger text-center p-2">
	<a href="/withdrawals">	<h6>Total Withdrawal</h6>
	<i class="fa fa-credit-card  icon"></i>
	<p class="">&#8358;{{numberKFormat($total_with)}}</p></a>

</div>
</div>

<div class="col-lg-6 col-sm-6">
<div class="card bg-light text-center p-2">
	<a href="/staff">	<h3>Staffs</h3>
	<i class="fa fa-child icon" style="font-size: 32px;"></i>
	<h4 class="mt-1">{{$staff->count()}}</h4></a>
	<div class="row">
<!--
<div class="col-lg-6 col-sm-6">
	
<p class="mt-1">M.D. {{$md->count()}}</p>
	<p class="mt-1"> HRM {{$hrm->count()}}</p>

		<p class="mt-1">D.R.O. {{$dro->count()}}</p>
			<p class="mt-1">P.M. {{$pm->count()}}</p>
				<p class="mt-1">C.O.O. {{$coo->count()}}</p>
<p class="mt-1">C.F.O. {{$cfo->count()}}</p>
</div>

<div class="col-lg-6 col-sm-6">
	<p class="mt-1">B.D.O {{$bdo->count()}}</p>
	<p class="mt-1">B.D.M. {{$bdm->count()}}</p>
	<p class="mt-1">H.B.D.M {{$hbdm->count()}}</p>
	<p class="mt-1">T.S.O {{$tso->count()}}</p>
	<p class="mt-1">S.O {{$so->count()}}</p>
	<p class="mt-1">C.M O. {{$cmo->count()}}</p>
</div>-->
</div>
    <!--staffs graph data-->
     <div class="col-lg-12 ">
 

          <input type="hidden" id="pm" value="{{$pm->count()}}">
         <input type="hidden" id="dro" value="{{$dro->count()}}" >
          <input type="hidden" id="bdm" value="{{$bdm->count()}}" >
           <input type="hidden" id="bdo" value="{{$bdo->count()}}" >
            <input type="hidden" id="so" value="{{$so->count()}}" >
             <input type="hidden" id="tso" value="{{$tso->count()}}" >
              <input type="hidden" id="coo" value="{{$coo->count()}}" >
               <input type="hidden" id="cfo" value="{{$cfo->count()}}" >
               <input type="hidden" id="hrm" value="{{$hrm->count()}}" >
                <input type="hidden" id="cmo" value="{{$cmo->count()}}" >
                 <input type="hidden" id="md" value="{{$md->count()}}" >
                       <input type="hidden" id="hor" value="{{$hor->count()}}" >
                             <input type="hidden" id="ea" value="{{$ea->count()}}" >
                                   <input type="hidden" id="abdm" value="{{$abdm->count()}}" >
                                         <input type="hidden" id="abdo" value="{{$abdo->count()}}" >
                                               <input type="hidden" id="fdo" value="{{$fdo->count()}}" >
                                                     <input type="hidden" id="cd" value="{{$cd->count()}}" >
                                                           <input type="hidden" id="oa" value="{{$oa->count()}}" >
                                                                 <input type="hidden" id="ao" value="{{$ao->count()}}" >
          <input type="hidden" id="hbdm" value="{{$hbdm->count()}}" name="">
     

  <canvas id="barChart3" width="400" height="800" ></canvas>    
    </div>
</div>

</div>
<div class="col-lg-6 col-sm6">
  <div class="col-lg-12 bg-light p-3">

<div class="row">
  
  <!--transaction graph data-->
    <div class="col-lg-6">
  
        

         
        
        
  <canvas id="barChart" width="400" height="800"></canvas>    
  
    </div>
  <!--products graph data-->
     <div class="col-lg-6 bg-light">
 

          <input type="hidden" id="stock" value="{{$stocks->count()}}" name="stock">
         <input type="hidden" id="ui" value="{{$puis->count()}}" name="ui">
          <input type="hidden" id="sold" value="{{$solds->count()}}" name="sold">
     

  <canvas id="barChart2" width="400" height="800"></canvas>    
    </div>


     <!--products graph data-->
     <div class="col-lg-12 bg-light mt-3">
 
  <h6 class="text-center">Last Five Deposit</h6>
<div class="table-responsive">
@php
{{
$deposits =DB::table('deposits')->where('status','success')->orderby('created_at','DESC')->take(5)->get();
}}

@endphp
  <table class="table table-stripped">
  	<thead>
  		<th>
  			Customer ID
  		</th>

  		<th>
  			Amount
  		</th>

  		<th>
  			Date
  		</th>
  	</thead>
  	<tbody>
  	@foreach($deposits as $deposit)
  		<tr>
  			<td>
  				<b>{{$deposit->customer_reg_no}}</b>
  			</td>
  			<td>
  				<b>&#8358;{{$deposit->amount}}</b>
  			</td>
  			<td>
  			@php
  			{{
$date =date('D d, F Y ',strtotime($deposit->created_at));
  			}}
  			@endphp


  				<b>{{$date}}</b>
  			</td>
  		</tr>
  		@endforeach
  	</tbody>
  </table>
    </div>
</div>
   

    
    

</div>
</div>
</div>



</div>
@elseif(Auth::user()->staffprofile->role =='DRO' || Auth::user()->staffprofile->role =='EA' || Auth::user()->staffprofile->role =='AO')


<div class="row">
@php
{{
$customers =DB::table('users')->join('customer_profiles','users.id','=','customer_profiles.user_id')->where('users.user_status','active')->where('users.user_type','customer')->where('customer_profiles.dro_id',Auth::user()->id)->count();

$cps =DB::table('customer_properties')->where('dro_reg_no',Auth::user()->staffprofile->reg_no)->count();
}}
@endphp
<div class="col-lg-6 offset-lg-3">
<div class="row mt-lg-5">
<div class="col-lg-6 col-sm-4">
<div class="card bg-info text-center p-2">

<a href="/customer">	<h6>Customers</h6>

	<i class="fa fa-users icon"></i>

	<p class="mt-lg-4">{{$customers ?? 0 }}</p>
	</a>

</div>
</div>

<div class="col-lg-6 col-sm-4">
<div class="card bg-light text-center p-2">

<a href="/customer">	<h6>Products</h6>

	<i class="fa fa-cart-plus icon"></i>

	<p class="mt-lg-4">{{$cps ?? 0}}</p>
	</a>

</div>
</div>
</div>
</div>
</div>

@elseif(Auth::user()->staffprofile->role =='PM' ||  Auth::user()->staffprofile->role =='AHO')


<div class="row">
@php
{{
$customers = DB::table('customer_profiles')->where('po_id',Auth::user()->id)->count();
$cps =DB::table('customer_properties')->get();
}}
@endphp
<div class="col-lg-6 offset-lg-3">
<div class="row mt-lg-5">
<div class="col-lg-6 col-sm-4">
<div class="card bg-info text-center p-2">

<a href="/customer">	<h6>Customers</h6>

	<i class="fa fa-users icon"></i>

	<p class="mt-lg-4">{{$customers ?? 0}}</p>
	</a>

</div>
</div>

<div class="col-lg-6 col-sm-4">
<div class="card bg-light text-center p-2">

<a href="/customer">	<h6>Products</h6>

	<i class="fa fa-cart-plus icon"></i>

	<p class="mt-lg-4">{{$cps->count()}}</p>
	</a>

</div>
</div>
</div>
</div>
</div>



@elseif(Auth::user()->staffprofile->role =='TSO' || Auth::user()->staffprofile->role =='SO')


<div class="row">
@php
{{

$customers =DB::table('users')->join('customer_profiles','users.id','=','customer_profiles.user_id')->where('users.user_status','active')->where('users.user_type','customer')->count();
$brands =DB::table('plot_types')->get();
$products =DB::table('products')->get();
$stocks =DB::table('plots')->where('status','unsold')->get();
$puis =DB::table('plots')->where('status','pending')->get();
$solds =DB::table('plots')->where('status','sold')->get();
}}
@endphp
<div class="col-lg-10 offset-lg-1 mt-lg-6-10">
<div class="row mt-lg-5">
    
<div class="col-lg-3 col-sm-4">
<div class="card bg-dark text-center p-2">
<a href="/customer">	<h6>Customers</h6>
	<i class="fa fa-users icon"></i>
	<p class="mt-lg-4">{{$customers ?? 0}}</p>
	</a>

</div>
</div>
<div class="col-lg-3 col-sm-4">
<div class="card bg-success text-center p-2">
<a href="/package">	<h6>Brands</h6>
	<i class="fa fa-list icon"></i>
	<p class="mt-lg-4">{{$brands->count()}}</p>
	</a>

</div>
</div>

<div class="col-lg-3 col-sm-4">
<div class="card bg-light text-center p-2">
<a href="/product">	<h6>Product Location</h6>
	<i class="fa fa-map icon"></i>
	<p class="mt-lg-4">{{$products->count()}}</p></a>

</div>
</div>
<div class="col-lg-3 col-sm-4">
<div class="card bg-primary text-center p-2">
<a href="/product">	<h6>Stock</h6>
	<i class="fa fa-cart-plus icon"></i>
	<p class="mt-lg-4">{{$stocks->count()}}</p></a>

</div>
</div>
</div>
</div>
</div>


@elseif(Auth::user()->staffprofile->role =='BDO' || Auth::user()->staffprofile->role =='BDM' || Auth::user()->staffprofile->role =='ABDM' || Auth::user()->staffprofile->role =='ABDO')


<div class="row">
@php
{{

  $dros = DB::table('staff_profiles')->where('designated_state',Auth::user()->staffprofile->designated_state)->where('role','DRO')->get();
 

$customers =DB::table('users')->join('customer_profiles','users.id','=','customer_profiles.user_id')->where('users.user_status','active')->where('users.user_type','customer')->where('customer_profiles.designated_state',Auth::user()->staffprofile->designated_state)->count();
  $branchcustomers = DB::table('customer_profiles')->where('branch_id',Auth::user()->staffprofile->branch_id)->get();

  $sales = DB::table('customer_properties')->where('state',Auth::user()->staffprofile->designated_state)->get();
}}
@endphp

<div class="col-lg-6 offset-lg-3">
<div class="row mt-lg-5">
<div class="col-lg-6 col-sm-4">
<div class="card bg-info text-center p-2">

<a href="#">	
<h6>Regional Customers</h6>

	<i class="fa fa-users icon"></i>

	<p class="mt-lg-4">{{$customers ??  0}}</p>
	</a>

</div>
</div>

<div class="col-lg-6 col-sm-4">
<div class="card bg-danger text-center p-2">

<a href="/bdmcustomers">	<h6>Branch Customers</h6>

	<i class="fa fa-users icon"></i>

	<p class="mt-lg-4">{{$branchcustomers->count()}}</p>
	</a>

</div>
</div>


<div class="col-lg-6 col-sm-4">
<div class="card bg-secondary text-center p-2">

<a href="/droportal">	<h6>D.R.O</h6>

	<i class="fa fa-users icon"></i>

	<p class="mt-lg-4">{{$dros->count()}}</p>
	</a>

</div>
</div>

<div class="col-lg-6 col-sm-4">
<div class="card bg-primary text-center p-2">

<a href="/bdmsales">	<h6>Sales</h6>

	<i class="fa fa-cart-plus icon"></i>

	<p class="mt-lg-4">{{$sales->count()}}</p>
	</a>

</div>
</div>
</div>
</div>
</div>



@elseif(Auth::user()->staffprofile->role =='HOR' )


<div class="row">
@php
{{

}}
@endphp
<div class="col-lg-6 offset-lg-3">
<div class="row mt-lg-5">
<div class="col-lg-6 col-sm-6">
<div class="card bg-danger text-center p-2">
  <a href="/defaulters"><h6> Defaulters</h6>
  <i class="fa fa-users  icon"></i>
  <p class="mt-lg-4">{{$defaulters->count()}}</p></a>

</div>
</div>

</div>
</div>
</div>



@elseif(Auth::user()->staffprofile->role =='CMO' || Auth::user()->staffprofile->role =='FDO' || Auth::user()->staffprofile->role =='CD')


<div class="row">
@php
{{


$customers =DB::table('users')->join('customer_profiles','users.id','=','customer_profiles.user_id')->where('users.user_status','active')->where('users.user_type','customer')->count();
$stocks =DB::table('plots')->where('status','unsold')->get();
$puis =DB::table('plots')->where('status','pending')->get();
$solds =DB::table('plots')->where('status','sold')->get();


}}
@endphp
<div class="col-lg-12 offset-lg-0">
<div class="row ">
<div class="col-lg-3 col-sm-6">
<div class="card bg-info text-center p-2">
<a href="/customer">	<h6>Customers</h6>

	<i class="fa fa-users icon"></i>

	<p class="mt-lg-4">{{$customers ?? 0}}</p>
	</a>

</div>
</div>



<div class="col-lg-3 col-sm-6">
<div class="card bg-primary text-center p-2">
<a href="/product">	<h6>Stock</h6>
	<i class="fa fa-cart-plus icon"></i>
	<p class="mt-lg-4">{{$stocks->count()}}</p></a>

</div>
</div>

<div class="col-lg-3 col-sm-6">
<div class="card bg-warning text-center p-2">
<a href="/installmentsales"><h6>Under Installment</h6>
	<i class="fa fa-shopping-cart  icon"></i>
	<p class="mt-lg-4">{{$puis->count()}}</p></a>

</div>
</div>
<div class="col-lg-3 col-sm-6">
<div class="card bg-success text-center p-2">
<a href="/sales">	<h6>Sold Out</h6>
	<i class="fa fa-shopping-cart  icon"></i>
	<p class="mt-lg-4">{{$solds->count()}}</p></a>

</div>
</div>

</div>
</div>
<div class="col-lg-12">
<div class="row">
  <div class="col-lg-12 bg-light">
 

          <input type="hidden" id="stock" value="{{$stocks->count()}}" name="stock">
         <input type="hidden" id="ui" value="{{$puis->count()}}" name="ui">
          <input type="hidden" id="sold" value="{{$solds->count()}}" name="sold">
     

  <canvas id="barChart2" width="400" height="400"></canvas>    
    </div>
    </div>
</div>


<!--HRM-->
@elseif(Auth::user()->staffprofile->role =='HRM')
<!--query all MD statistics-->
@php
{{


$staff=DB::table('users')->where('user_type','staff')->get();
$md =DB::table('staff_profiles')->where('role','MD')->get();
$hrm =DB::table('staff_profiles')->where('role','HRM')->get();
$cmo =DB::table('staff_profiles')->where('role','CMO')->get();
$dro=DB::table('staff_profiles')->where('role','DRO')->get();
$pm =DB::table('staff_profiles')->where('role','PM')->get();
$bdo =DB::table('staff_profiles')->where('role','BDO')->get();
$bdm =DB::table('staff_profiles')->where('role','BDM')->get();
$hbdm =DB::table('staff_profiles')->where('role','HBDM')->get();
$coo =DB::table('staff_profiles')->where('role','COO')->get();
$cfo =DB::table('staff_profiles')->where('role','CFO')->get();
$tso =DB::table('staff_profiles')->where('role','TSO')->get();
$so =DB::table('staff_profiles')->where('role','SO')->get();
$cd =DB::table('staff_profiles')->where('role','CD')->get();
$fdo =DB::table('staff_profiles')->where('role','FDO')->get();
$oa =DB::table('staff_profiles')->where('role','OA')->get();
$ea =DB::table('staff_profiles')->where('role','EA')->get();
$aho =DB::table('staff_profiles')->where('role','AHO')->get();
$abdm =DB::table('staff_profiles')->where('role','ABDM')->get();
$abdo =DB::table('staff_profiles')->where('role','ABDO')->get();
$hor =DB::table('staff_profiles')->where('role','HOR')->get();
$ao =DB::table('staff_profiles')->where('role','AO')->get();
$branches =DB::table('branches')->get();
$brands =DB::table('plot_types')->get();
$products =DB::table('products')->get();
$stocks =DB::table('plots')->where('status','unsold')->get();
$puis =DB::table('plots')->where('status','pending')->get();
$solds =DB::table('plots')->where('status','sold')->get();
$pstaffs =DB::table('staff_profiles')->where('status','inactive')->get();
$date =date('Y-m-d');

}}

@endphp

<div class="row">



<div class="col-lg-4 col-sm-4">
<div class="card bg-warning text-center p-2">
<a href="/pendingstaffreg">	<h6>Pending Staff</h6>
	<i class="fa fa-users icon"></i>
	<p class="mt-lg-4">{{$pstaffs->count()}}</p></a>

</div>
</div>

<div class="col-lg-4 col-sm-4">
<div class="card bg-light text-center p-2">
<a href="/product">	<h6>Product Location</h6>
	<i class="fa fa-map icon"></i>
	<p class="mt-lg-4">{{$products->count()}}</p></a>

</div>
</div>





<div class="col-lg-4 col-sm-4">
<div class="card bg-primary text-center p-2">
<a href="/product">	<h6>Stock</h6>
	<i class="fa fa-cart-plus icon"></i>
	<p class="mt-lg-4">{{$stocks->count()}}</p></a>

</div>
</div>

<div class="col-lg-12 col-sm-12">
<div class="card bg-light text-center p-2">
	<a href="/staff">	<h3>Staffs</h3>
	<i class="fa fa-child icon" style="font-size: 32px;"></i>
	<h4 class="mt-lg-4">{{$staff->count()}}</h4></a>
	<div class="row">
<!--
<div class="col-lg-6 col-sm-6">
	
<p class="mt-1">M.D. {{$md->count()}}</p>
	<p class="mt-1"> HRM {{$hrm->count()}}</p>

		<p class="mt-1">D.R.O. {{$dro->count()}}</p>
			<p class="mt-1">P.M. {{$pm->count()}}</p>
				<p class="mt-1">C.O.O. {{$coo->count()}}</p>
<p class="mt-1">C.F.O. {{$cfo->count()}}</p>
</div>

<div class="col-lg-6 col-sm-6">
	<p class="mt-1">B.D.O {{$bdo->count()}}</p>
	<p class="mt-1">B.D.M. {{$bdm->count()}}</p>
	<p class="mt-1">H.B.D.M {{$hbdm->count()}}</p>
	<p class="mt-1">T.S.O {{$tso->count()}}</p>
	<p class="mt-1">S.O {{$so->count()}}</p>
	<p class="mt-1">C.M O. {{$cmo->count()}}</p>
</div>-->
</div>
    <!--staffs graph data-->
     <div class="col-lg-12 ">
 

          <input type="hidden" id="pm" value="{{$pm->count()}}">
         <input type="hidden" id="dro" value="{{$dro->count()}}" >
          <input type="hidden" id="bdm" value="{{$bdm->count()}}" >
           <input type="hidden" id="bdo" value="{{$bdo->count()}}" >
            <input type="hidden" id="so" value="{{$so->count()}}" >
             <input type="hidden" id="tso" value="{{$tso->count()}}" >
              <input type="hidden" id="coo" value="{{$coo->count()}}" >
               <input type="hidden" id="cfo" value="{{$cfo->count()}}" >
               <input type="hidden" id="hrm" value="{{$hrm->count()}}" >
                <input type="hidden" id="cmo" value="{{$cmo->count()}}" >
                 <input type="hidden" id="md" value="{{$md->count()}}" >
                  <input type="hidden" id="hor" value="{{$hor->count()}}" >
                             <input type="hidden" id="ea" value="{{$ea->count()}}" >
                                   <input type="hidden" id="abdm" value="{{$abdm->count()}}" >
                                         <input type="hidden" id="abdo" value="{{$abdo->count()}}" >
                                               <input type="hidden" id="fdo" value="{{$fdo->count()}}" >
                                                     <input type="hidden" id="cd" value="{{$cd->count()}}" >
                                                           <input type="hidden" id="oa" value="{{$oa->count()}}" >
                                                                 <input type="hidden" id="ao" value="{{$ao->count()}}" >
          <input type="hidden" id="hbdm" value="{{$hbdm->count()}}" name="">
     

  <canvas id="barChart3" width="400" height="400" ></canvas>    
    </div>
</div>

</div>

    
    

</div>
</div>
</div>



</div>


<!--HRM-->
@elseif(Auth::user()->staffprofile->role =='HBDM')
<!--query all MD statistics-->
@php
{{

$customers=DB::table('customer_profiles')->count();
$staff=DB::table('users')->where('user_type','staff')->get();
$md =DB::table('staff_profiles')->where('role','MD')->get();
$hrm =DB::table('staff_profiles')->where('role','HRM')->get();
$cmo =DB::table('staff_profiles')->where('role','CMO')->get();
$dro=DB::table('staff_profiles')->where('role','DRO')->get();
$pm =DB::table('staff_profiles')->where('role','PM')->get();
$bdo =DB::table('staff_profiles')->where('role','BDO')->get();
$bdm =DB::table('staff_profiles')->where('role','BDM')->get();
$hbdm =DB::table('staff_profiles')->where('role','HBDM')->get();
$coo =DB::table('staff_profiles')->where('role','COO')->get();
$cfo =DB::table('staff_profiles')->where('role','CFO')->get();
$tso =DB::table('staff_profiles')->where('role','TSO')->get();
$so =DB::table('staff_profiles')->where('role','SO')->get();

$branches =DB::table('branches')->get();
$brands =DB::table('plot_types')->get();
$products =DB::table('products')->get();
$stocks =DB::table('plots')->where('status','unsold')->get();
$puis =DB::table('plots')->where('status','pending')->get();
$solds =DB::table('plots')->where('status','sold')->get();
$pstaffs =DB::table('staff_profiles')->where('status','inactive')->get();
$date =date('Y-m-d');

}}

@endphp

<div class="row">



<div class="col-lg-4 col-sm-4">
<div class="card bg-info text-center p-2">
<a href="/hbdmbdmlist">	<h6>BDM</h6>
	<i class="fa fa-child   icon"></i>
	<p class="mt-lg-4">{{$bdm->count()}}</p></a>

</div>
</div>

<div class="col-lg-4 col-sm-4">
<div class="card bg-light text-center p-2">
<a href="/hbdmbdolist">	<h6>BDO</h6>
	<i class="fa fa-child icon"></i>
	<p class="mt-lg-4">{{$bdo->count()}}</p></a>

</div>
</div>

<div class="col-lg-4 col-sm-4">
<div class="card bg-primary text-center p-2">
<a href="#">	<h6>DRO</h6>
	<i class="fa fa-child icon"></i>
	<p class="mt-lg-4">{{$dro->count()}}</p></a>

</div>
</div>





<div class="col-lg-4 col-sm-4">
<div class="card bg-secondary text-center p-2">
<a href="/hbdmcustomerslist">	<h6>Customers</h6>
	<i class="fa fa-users icon"></i>
	<p class="mt-lg-4">{{$customers ?? 0}}</p></a>

</div>
</div>

<div class="col-lg-4 col-sm-4">
<div class="card bg-success text-center p-2">
<a href="/hbdmsales">	<h6>Sales</h6>
	<i class="fa fa-cart-plus icon"></i>
	<p class="mt-lg-4">{{$solds->count()}}</p></a>

</div>
</div>
<div class="col-lg-4 col-sm-4">
<div class="card bg-danger text-center p-2">
<a href="/defaulters/create">	<h6>Defaulters</h6>
	<i class="fa fa-user icon"></i>
	<p class="mt-lg-4">{{$defaulters->count()}}</p></a>

</div>
</div>

    
    

</div>
</div>
</div>



</div>

<!--MD-->
@elseif(Auth::user()->staffprofile->role =='COO' || Auth::user()->staffprofile->role =='CFO')
<!--query all MD statistics-->
@php
{{

 $customer =DB::table('users')->join('customer_profiles','users.id','=','customer_profiles.user_id')->select('users.*','customer_profiles.*')->where('users.user_status','active')->where('users.user_type','customer')->get();
$staff=DB::table('users')->where('user_type','staff')->get();
$md =DB::table('staff_profiles')->where('role','MD')->get();
$hrm =DB::table('staff_profiles')->where('role','HRM')->get();
$cmo =DB::table('staff_profiles')->where('role','CMO')->get();
$dro=DB::table('staff_profiles')->where('role','DRO')->get();
$pm =DB::table('staff_profiles')->where('role','PM')->get();
$bdo =DB::table('staff_profiles')->where('role','BDO')->get();
$bdm =DB::table('staff_profiles')->where('role','BDM')->get();
$hbdm =DB::table('staff_profiles')->where('role','HBDM')->get();
$coo =DB::table('staff_profiles')->where('role','COO')->get();
$cfo =DB::table('staff_profiles')->where('role','CFO')->get();
$tso =DB::table('staff_profiles')->where('role','TSO')->get();
$so =DB::table('staff_profiles')->where('role','SO')->get();
$cd =DB::table('staff_profiles')->where('role','CD')->get();
$fdo =DB::table('staff_profiles')->where('role','FDO')->get();
$oa =DB::table('staff_profiles')->where('role','OA')->get();
$ea =DB::table('staff_profiles')->where('role','EA')->get();
$aho =DB::table('staff_profiles')->where('role','AHO')->get();
$abdm =DB::table('staff_profiles')->where('role','ABDM')->get();
$abdo =DB::table('staff_profiles')->where('role','ABDO')->get();
$hor =DB::table('staff_profiles')->where('role','HOR')->get();
$ao =DB::table('staff_profiles')->where('role','AO')->get();
$branches =DB::table('branches')->get();
$brands =DB::table('plot_types')->get();
$products =DB::table('products')->get();
$stocks =DB::table('plots')->where('status','unsold')->get();
$puis =DB::table('plots')->where('status','pending')->get();
$solds =DB::table('plots')->where('status','sold')->get();
$pstaffs =DB::table('staff_profiles')->where('status','inactive')->get();
$date =date('Y-m-d');

}}

@endphp

<div class="row">

<div class="col-lg-3 col-sm-4">
<div class="card bg-info text-center p-2">
<a href="/customer">	<h6>Customers</h6>

	<i class="fa fa-users icon"></i>

	<p class="mt-lg-4">{{$customer->count()}}</p>
	</a>

</div>
</div>









<div class="col-lg-3 col-sm-4">
<div class="card bg-light text-center p-2">
<a href="/product">	<h6>Product Location</h6>
	<i class="fa fa-map icon"></i>
	<p class="mt-lg-4">{{$products->count()}}</p></a>

</div>
</div>
<div class="col-lg-3 col-sm-4">
<div class="card bg-primary text-center p-2">
<a href="/product">	<h6>Stock</h6>
	<i class="fa fa-cart-plus icon"></i>
	<p class="mt-lg-4">{{$stocks->count()}}</p></a>

</div>
</div>

<div class="col-lg-3 col-sm-4">
<div class="card bg-warning text-center p-2">
<a href="/installmentsales">	<h6>Under Installment</h6>
	<i class="fa fa-shopping-cart  icon"></i>
	<p class="mt-lg-4">{{$puis->count()}}</p></a>

</div>
</div>
<div class="col-lg-3 col-sm-4">
<div class="card bg-success text-center p-2">
<a href="/sales">	<h6>Sold Out</h6>
	<i class="fa fa-shopping-cart  icon"></i>
	<p class="mt-lg-4">{{$solds->count()}}</p></a>

</div>
</div>

 <input type="hidden" id="acc" value="{{$arriers->sum('amount_due')}}" name="acc">
         <input type="hidden" id="cre" value="{{$deposits->sum('amount')}}" name="cre">
          <input type="hidden" id="edi" value="{{$adv->sum('amount')}}" name="edi">
           <input type="hidden" id="de" value="{{$defaulters->sum('amount_due')}}" name="edi">
@php
{{

$deposits =$deposits->sum('amount');
if(strlen($deposits) < 7 )
{

$deposits =number_format($deposits,2);
}
elseif(strlen($deposits) >=7 )
{
$deposits = $deposits/1000000;
$deposits =number_format($deposits,2).'M';
}
elseif(strlen($deposits) >=10 )
{
$deposits = $deposits/1000000000;
$deposits =number_format($deposits,2).'B';
}
elseif(strlen($deposits) >=13 )
{
$deposits = $deposits/1000000000000;
$deposits =number_format($deposits,2).'T';
}


$arriers =$arriers->sum('amount_due');
if(strlen($arriers) < 7 )
{

$arriers =number_format($arriers,2);
}
elseif(strlen($arriers) >=7 )
{
$arriers = $arriers/1000000;
$arriers =number_format($arriers,2).'M';
}
elseif(strlen($arriers) >=10 )
{
$arriers = $arriers/1000000000;
$arriers =number_format($arriers,2).'B';
}
elseif(strlen($arriers) >=13 )
{
$arriers = $arriers/1000000000000;
$arriers =number_format($arriers,2).'T';
}


$adv =$adv->sum('amount');
if(strlen($adv) < 7 )
{

$adv =number_format($adv,2);
}
elseif(strlen($adv) >=7 )
{
$adv = $adv/1000000;
$adv =number_format($adv,2).'M';
}
elseif(strlen($adv) >=10 )
{
$adv = $adv/1000000000;
$adv =number_format($adv,2).'B';
}
elseif(strlen($adv) >=13 )
{
$adv = $adv/1000000000000;
$adv =number_format($adv,2).'T';
}

}}
@endphp

<div class="col-lg-3 col-sm-4">
<div class="card bg-light text-center p-2">
	<a href="/deposittxn">	<h6>Current  Deposit</h6>
	<i class="fa fa-credit-card  icon"></i>
	<p class="mt-lg-4">&#8358;{{$deposits}}</p></a>

</div>
</div>

<div class="col-lg-2 col-sm-4">
<div class="card bg-danger text-center p-2">
	<a href="/defaulters/create"><h6> Defaulters</h6>
	<i class="fa fa-users  icon"></i>
	<p class="mt-lg-4">{{$defaulters->count()}}</p></a>

</div>
</div>
<div class="col-lg-2 col-sm-4">
<div class="card bg-info text-center p-2">
	<a href="/">	<h6>Advance Payment</h6>
	<i class="fa fa-credit-card   icon"></i>
	<p class="mt-lg-4">&#8358;{{$adv}}</p></a>

</div>
</div>
<div class="col-lg-2 col-sm-4">
<div class="card bg-danger text-center p-2">
	<a href="/arriers">	<h6>Outstanding Balance</h6>
	<i class="fa fa-credit-card  icon"></i>
	<p class="mt-lg-4">&#8358;{{$arriers}}</p></a>

</div>
</div>


<div class="col-lg-6 col-sm-6">
<div class="card bg-light text-center p-2">
	<a href="/staff">	<h3>Staffs</h3>
	<i class="fa fa-child icon" style="font-size: 32px;"></i>
	<h4 class="mt-1">{{$staff->count()}}</h4></a>
	<div class="row">
<!--
<div class="col-lg-6 col-sm-6">
	
<p class="mt-1">M.D. {{$md->count()}}</p>
	<p class="mt-1"> HRM {{$hrm->count()}}</p>

		<p class="mt-1">D.R.O. {{$dro->count()}}</p>
			<p class="mt-1">P.M. {{$pm->count()}}</p>
				<p class="mt-1">C.O.O. {{$coo->count()}}</p>
<p class="mt-1">C.F.O. {{$cfo->count()}}</p>
</div>

<div class="col-lg-6 col-sm-6">
	<p class="mt-1">B.D.O {{$bdo->count()}}</p>
	<p class="mt-1">B.D.M. {{$bdm->count()}}</p>
	<p class="mt-1">H.B.D.M {{$hbdm->count()}}</p>
	<p class="mt-1">T.S.O {{$tso->count()}}</p>
	<p class="mt-1">S.O {{$so->count()}}</p>
	<p class="mt-1">C.M O. {{$cmo->count()}}</p>
</div>-->
</div>
    <!--staffs graph data-->
     <div class="col-lg-12 ">
 

          <input type="hidden" id="pm" value="{{$pm->count()}}">
         <input type="hidden" id="dro" value="{{$dro->count()}}" >
          <input type="hidden" id="bdm" value="{{$bdm->count()}}" >
           <input type="hidden" id="bdo" value="{{$bdo->count()}}" >
            <input type="hidden" id="so" value="{{$so->count()}}" >
             <input type="hidden" id="tso" value="{{$tso->count()}}" >
              <input type="hidden" id="coo" value="{{$coo->count()}}" >
               <input type="hidden" id="cfo" value="{{$cfo->count()}}" >
               <input type="hidden" id="hrm" value="{{$hrm->count()}}" >
                <input type="hidden" id="cmo" value="{{$cmo->count()}}" >
                 <input type="hidden" id="md" value="{{$md->count()}}" >
                  <input type="hidden" id="hor" value="{{$hor->count()}}" >
                             <input type="hidden" id="ea" value="{{$ea->count()}}" >
                                   <input type="hidden" id="abdm" value="{{$abdm->count()}}" >
                                         <input type="hidden" id="abdo" value="{{$abdo->count()}}" >
                                               <input type="hidden" id="fdo" value="{{$fdo->count()}}" >
                                                     <input type="hidden" id="cd" value="{{$cd->count()}}" >
                                                           <input type="hidden" id="oa" value="{{$oa->count()}}" >
                                                                 <input type="hidden" id="ao" value="{{$ao->count()}}" >
          <input type="hidden" id="hbdm" value="{{$hbdm->count()}}" name="">
     

  <canvas id="barChart3" width="400" height="400" ></canvas>    
    </div>
</div>

</div>
<div class="col-lg-6 col-sm6">
  <div class="col-lg-12 bg-light p-3">

<div class="row">
  
  <!--transaction graph data-->
    <div class="col-lg-6">
  
       
        

         
        
        
  <canvas id="barChart" width="400" height="400"></canvas>    
  
    </div>
  <!--products graph data-->
     <div class="col-lg-6 bg-light">
 

          <input type="hidden" id="stock" value="{{$stocks->count()}}" name="stock">
         <input type="hidden" id="ui" value="{{$puis->count()}}" name="ui">
          <input type="hidden" id="sold" value="{{$solds->count()}}" name="sold">
     

  <canvas id="barChart2" width="400" height="400"></canvas>    
    </div>


     <!--products graph data-->
     <div class="col-lg-12 bg-light mt-3">
 
  <h6 class="text-center">Last Five Deposit</h6>
<div class="table-responsive">
@php
{{
$deposits =DB::table('deposits')->where('status','success')->orderby('created_at','DESC')->take(5)->get();
}}

@endphp
  <table class="table table-stripped">
  	<thead>
  		<th>
  			Customer ID
  		</th>

  		<th>
  			Amount
  		</th>

  		<th>
  			Date
  		</th>
  	</thead>
  	<tbody>
  	@foreach($deposits as $deposit)
  		<tr>
  			<td>
  				<b>{{$deposit->customer_reg_no}}</b>
  			</td>
  			<td>
  				<b>&#8358;{{$deposit->amount}}</b>
  			</td>
  			<td>
  			@php
  			{{
$date =date('D d, F Y ',strtotime($deposit->created_at));
  			}}
  			@endphp


  				<b>{{$date}}</b>
  			</td>
  		</tr>
  		@endforeach
  	</tbody>
  </table>
    </div>
</div>
   

    
    

</div>
</div>
</div>



</div>
@endif
@stop

@section('js')
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script> 
<script>
var canvas = document.getElementById("barChart");
var ctx = canvas.getContext('2d');
var acc = $('#acc').val();
var cre = $('#cre').val();
var edi = $('#edi').val();
var de = $('#de').val();
// Global Options:
 Chart.defaults.global.defaultFontColor = 'black';
 Chart.defaults.global.defaultFontSize = 16;

var data = {
    labels: ["Outstanding Balance ", "Advance","Default","Deposit"],
      datasets: [
        {
            fill: true,
            backgroundColor: [
                'green',
                'skyblue','red','orange'],
            data: [acc, edi,de, cre],
// Notice the borderColor 
            borderColor:	['black', 'black','red','black'],
            borderWidth: [2,2,2,2]
        }
    ]
};

// Notice the rotation from the documentation.

var options = {
        title: {
                  display: true,
                  text: 'Transaction',
                  position: 'top'
              },
        rotation: -0.7 * Math.PI
};


// Chart declaration:
var myBarChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: options
});

</script>

<script>
var canvas = document.getElementById("barChart2");
var ctx = canvas.getContext('2d');
var acc = $('#stock').val();
var cre = $('#ui').val();
var edi = $('#sold').val();
// Global Options:
 Chart.defaults.global.defaultFontColor = 'black';
 Chart.defaults.global.defaultFontSize = 16;

var data = {
    labels: ["In stock ", "Under Installment","Sold Out"],
      datasets: [
        {
            fill: true,
            backgroundColor: [
                'green',
                'skyblue','yellow'],
            data: [acc, cre, edi],
// Notice the borderColor 
            borderColor:	['green', 'skyblue','yellow'],
            borderWidth: [2,2,2]
        }
    ]
};

// Notice the rotation from the documentation.

var options = {
        title: {
                  display: true,
                  text: 'Products',
                  position: 'top'
              },
        rotation: -0.7 * Math.PI
};


// Chart declaration:
var myBarChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: options
});

</script>


<script>
var canvas = document.getElementById("barChart3");
var ctx = canvas.getContext('2d');
var pm = $('#pm').val();
var dro = $('#dro').val();
var bdm = $('#bdm').val();
var bdo = $('#bdo').val();
var hbdm = $('#hbdm').val();
var tso = $('#tso').val();
var so = $('#so').val();
var cfo = $('#cfo').val();
var coo = $('#coo').val();
var hrm = $('#hrm').val();
var cmo = $('#cmo').val();
var md = $('#md').val();

var oa = $('#oa').val();
var ao = $('#ao').val();
var hor = $('#hor').val();
var cd = $('#cd').val();
var fdo = $('#fdo').val();
var abdm= $('#abdm').val();
var abdo = $('#abdo').val();
var ea = $('#ea').val();
var aho = $('#aho').val();

// Global Options:
 Chart.defaults.global.defaultFontColor = 'black';
 Chart.defaults.global.defaultFontSize = 16;

var data = {
    labels: ["PM ", "DRO","BDM","BDO",'HBDM',"TSO","SO","CFO","COO","HRM","CMO","MD","OA","AO","HOR","CD","FDO","ABDO","ABDM","EA","AHO"],
      datasets: [
        {
            fill: true,
            backgroundColor: [
                'lightgreen',
                'skyblue','yellow','pink','purple','brown','red','blue','orange','grey','black','maroon','#000088','gold','royalblue','lightblue','lavender','cyan','violet','#ccc','green'],
            data: [pm, dro, bdm, bdo, hbdm,tso,so,cfo,coo,hrm,cmo,md,oa,ao,hor,cd,fdo,abdo,abdm,ea,aho],
// Notice the borderColor 
            borderColor:	['lightgreen', 'skyblue','yellow' ,'pink','purple','brown','red','blue','orange','grey','black','maroon','#000088','gold','royalblue','lightblue','lavender','cyan','violet','#ccc','green'],
            borderWidth: [2,2,2]
        }
    ]
};

// Notice the rotation from the documentation.

var options = {
        title: {
                  display: true,
                  text: 'Staffs',
                  position: 'top'
              },
        rotation: -0.7 * Math.PI
};


// Chart declaration:
var myBarChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: options
});

</script>


@stop