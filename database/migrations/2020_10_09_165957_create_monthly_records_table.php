<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_records', function (Blueprint $table) {
                 $table->bigIncrements('id');
         
            $table->unsignedBigInteger('user_id');
             $table->decimal('amount',12,2)->default(0.00);
             $table->unsignedBigInteger('customerproperty_id');
             $table->string('fullname')->nullable();
             $table->string('email')->nullable();
             
             $table->string('phone')->nullable();
             $table->string('branch')->nullable();
             $table->string('state')->nullable();
             $table->string('month')->nullable();
              $table->enum('status',['pending','success','cancel'])->default('pending');
              
            $table->timestamps();
        });
         Schema::table('monthly_records', function($table){
            $table->foreign('user_id')->references('id')->on('users');     
            $table->foreign('customerproperty_id')->references('id')->on('customer_properties');   
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_records');
    }
}
