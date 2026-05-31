<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_transfers', function (Blueprint $table) {
             $table->bigIncrements('id');
            
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
             $table->enum('status',['pending','success','failed'])->default('pending');
              $table->decimal('amount',12,2)->default(0.00);
              $table->foreign('sender_id')->references('id')->on('users')->onDelete('set null');  
             $table->foreign('receiver_id')->references('id')->on('users')->onDelete('set null');  
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
        Schema::dropIfExists('internal_transfers');
    }
}
