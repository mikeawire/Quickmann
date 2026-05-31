<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartialPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partial_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customerproperty_id');
            $table->decimal('amount',12,2)->default(0.00);
            $table->decimal('monthly_payment',12,2)->default(0.00);
            $table->enum('status',['processing','success','cancel'])->default('processing');
            $table->string('paystack_plan')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('email_token')->nullable();
            $table->string('authorization')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

          Schema::table('partial_payments', function($table){
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
        Schema::dropIfExists('partial_payments');
    }
}
