<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_transactions', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
             $table->string('type')->nullable();
             $table->string('cd')->nullable();
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
        Schema::dropIfExists('other_transactions');
    }
}
