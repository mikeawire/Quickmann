<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount',12,2)->default(0.00);
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('customer_property_id')->nullable();
            $table->unsignedBigInteger('plot_id')->nullable();
            $table->string('authorization_code')->nullable();
            $table->string('customer_reg_no')->nullable();
            $table->string('ref_id')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('paid_at')->nullable();
            $table->string('channel')->nullable();
            $table->string('currency')->nullable();
            $table->string('mobile')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('fees')->nullable();
            $table->string('bin')->nullable();
            $table->string('last4')->nullable();
            $table->string('exp_year')->nullable();
            $table->string('exp_month')->nullable();
            $table->string('card_type')->nullable();
            $table->string('bank')->nullable();
            $table->string('country_code')->nullable();
            $table->string('account_name')->nullable();

            $table->enum('payment_method',['online','offline','bank'])->default('online');
            $table->enum('payment_type',['initial','outright','installment','topup'])->default('initial');
            
            
            $table->enum('status',['pending','success','cancel'])->default('pending');
            
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('deposits', function($table){
            $table->foreign('customer_id')->references('id')->on('users');     
            $table->foreign('plot_id')->references('id')->on('plots');   
            $table->foreign('customer_property_id')->references('id')->on('customer_properties'); 
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
