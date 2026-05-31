<?php

namespace App\Exports;

use App\Models\Deposit;
use App\Models\Plot;
use App\Models\CustomerProperty;
use DB;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection,  WithHeadings
{
	   //use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
     

  $cps =DB::table('customer_properties')
  ->join('users','customer_properties.customer_id','users.id')
    ->join('customer_profiles','customer_profiles.user_id','users.id')
    ->join('plots','customer_properties.plot_id','plots.id')
    ->join('products','plots.product_id','products.id')
     ->join('staff_profiles','staff_profiles.reg_no','customer_properties.dro_reg_no')
    ->select('customer_properties.created_at','customer_profiles.surname','customer_profiles.first_name','customer_profiles.othername','plots.sqm','products.location_name','products.address','products.town','products.state','products.no_of_plots','customer_properties.property_price','customer_properties.total_amount_paid','customer_properties.unpaid_balance','staff_profiles.surname as s_name','staff_profiles.first_name as f_name ','staff_profiles.othername as oth_name' )
    ->where('customer_properties.property_status','preown')
     ->where('customer_properties.unpaid_balance','>',0)
    ->get();
       
        
       
        return $cps;
    
        
      

    }

     public function headings(): array
    {
        return [
            'Commence Date',
            'Surname',
            'First Name',
            'Othername',
            'SQM',
            'Location',
             'Address',
            'Town',
            'State',
            'No Of Plots',
            'Property Price',
            'Total Amount Paid',
            'Balance',
            'D.R.O Surname',
            'D.R.O First Name',
            'D.R.O Othername',
            'Remark',
        ];
    }
}
