<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
           $table->bigIncrements('id');
         
            $table->unsignedBigInteger('user_id');
                   $table->unsignedBigInteger('plot_id');
             $table->string('customer_reg_no')->nullable();
                $table->string('fullname')->nullable();
                  $table->string('phone')->nullable();
                    $table->string('branch')->nullable();
                      $table->string('state')->nullable();
                        $table->string('plot_no')->nullable();
                          $table->string('location_name')->nullable();
                            $table->string('Brand')->nullable();
                              $table->string('ref_id')->nullable();
                     $table->string('txn_id')->nullable();
                     $table->decimal('amount',12,2)->default(0.00);
                      $table->string('no_of_times')->nullable();
                       $table->enum('payment_method',['online','offline','bank'])->default('online');
                        $table->enum('status',['pending','success','cancel'])->default('pending');
                        
                        $table->enum('payment_type',['initial','outright','monthly'])->default('initial');
                            $table->softDeletes();
                     $table->timestamps();
        });
         Schema::table('transactions', function($table){
            $table->foreign('user_id')->references('id')->on('users');     
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
        Schema::dropIfExists('transactions');
    }
}
