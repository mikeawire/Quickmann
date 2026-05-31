<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('customer_reg_no');
            $table->unsignedBigInteger('plot_id');
            $table->decimal('initial_deposit',12,2)->default(0.00);
            $table->string('no_of_installment')->nullable();
            $table->string('no_of_remaining_installment')->nullable();
            $table->decimal('total_amount_paid',12,2)->default(0.00);
            $table->decimal('unpaid_balance',12,2)->default(0.00);
            $table->decimal('property_price',12,2)->default(0.00);
            $table->enum('payment_type',['installment','outright'])->default('installment');
            $table->enum('payment_status',['complete','incomplete'])->default('incomplete');
            $table->enum('property_status',['own','preown','revoked'])->default('preown');
           
            $table->timestamps();
        });
        Schema::table('customer_properties', function($table){
            $table->foreign('customer_id')->references('id')->on('users');     
            $table->foreign('plot_id')->references('id')->on('plots');   
          
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_properties');
    }
}
 