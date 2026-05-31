<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
              $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
             $table->string('duration')->nullable();
             $table->string('profit')->nullable();
             $table->string('rate')->nullable();
             $table->string('ref')->nullable();
             $table->enum('status',['in progress','completed','liquidated','liquidation requested'])->default('in progress');
             $table->decimal('amount',12,2)->default(0.00);
             $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');  
             $table->timestamp('liquidation_date')->nullable();
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
        Schema::dropIfExists('investments');
    }
}
