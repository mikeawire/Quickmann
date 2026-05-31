<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
             $table->string('account_number')->nullable();
             $table->string('account_name')->nullable();
            $table->string('bank_name')->nullable();
             $table->string('account_type')->nullable();
             $table->enum('status',['pending','success','failed'])->default('pending');
             $table->decimal('amount',12,2)->default(0.00);
               $table->text('remark')->nullable();
              $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
}
