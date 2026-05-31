<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\CustomerProperty;
use App\Models\StaffProfile;
use DB;
class StaffPerformance extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
      

       
       
    }
    
    
    
    
    public function index()
    {

      if(Auth::user()->staffprofile->role =='HRM' ||  Auth::user()->staffprofile->role =='MD')
        {
      
        return view('Staff.performance.index');
        }
        else
        {      return redirect('/home');
        }
     
    }
    
    
    
     public function search(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required',
            
   
       ]);
       
         
       
      
  
       return redirect('/sales-performance-result?month='.$request->month.'&year='.$request->year);
    }
    
       public function salesReport(Request $request)
    {

      if(Auth::user()->staffprofile->role =='HRM' ||  Auth::user()->staffprofile->role =='MD')
        {
            
        if(!$request->has('year') || !$request->has('month'))
        {
            return redirect('/search-performance');
        }
        
        
        
        

$results = StaffProfile::leftJoin('customer_properties', function ($join) use ($request) {
    $join->on('staff_profiles.reg_no', '=', 'customer_properties.dro_reg_no')
        ->whereYear('customer_properties.created_at', $request->year)
        ->whereMonth('customer_properties.created_at', $request->month);
})
->join('branches','branches.id','staff_profiles.branch_id')
->select(
    'staff_profiles.surname',
    'staff_profiles.first_name',
    'staff_profiles.othername',
    'staff_profiles.reg_no',
    'branches.name as branch_name',
    DB::raw('COUNT(customer_properties.dro_reg_no) as total')
)
->groupBy('staff_profiles.surname', 'staff_profiles.first_name', 'staff_profiles.othername', 'staff_profiles.reg_no','branches.name')
->orderBy('total', 'DESC')
->get();
         $i=1;
         $month=$request->month;
        $year=$request->year;
     
        return view('Staff.performance.sales-report')->with(compact('results','i','year','month'));
        }
        else
        {      return redirect('/home');
        }
     
    }
    
}
