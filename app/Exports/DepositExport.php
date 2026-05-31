<?php

namespace App\Exports;

use App\Models\Deposit;
use App\Models\Plot;
use Maatwebsite\Excel\Concerns\FromCollection;

class DepositExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $deposits =Deposit::get('amount','amount');
        foreach ($deposits as $deposit)
        {
              $plots =Plot::find($deposit->plot_id);
                      
        
        return $deposits;
    
        }
      

    }
}
