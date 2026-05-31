<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CustomerProperty;
use App\Models\Plot;
class PropertyCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'property:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        foreach($this->getProperties() as $property)
        {
            $plot=Plot::find($property->plot_id);
            if($plot && $plot->status=="pending")
            {
                $plot->status = "sold";
                $plot->save();
               
            }
            $property->property_status="own";
             $property->payment_status="complete";
            $property->save();
        }
    }
    
    public function getProperties()
    {
       return $properties = CustomerProperty::where('property_status','preown')->where('unpaid_balance','<',1)->get();
    }
}
