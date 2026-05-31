<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
             $table->string('title')->nullable();
             $table->longText('message')->nullable();
              $table->timestamp('schedule_date')->nullable();
              $table->timestamp('reschedule_date')->nullable();
             $table->enum('status',['pending','past','awaiting reschedule approval','approved','declined'])->default('pending');
              $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');  
                 $table->foreign('property_id')->references('id')->on('customer_properties')->onDelete('set null');
           
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
        Schema::dropIfExists('appointments');
    }
}
