<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('othername')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('address')->nullable();
            $table->string('second_phone')->nullable();
            $table->string('reg_no')->nullable();
            $table->string('profile_photo')->nullable();
          
            $table->enum('gender',['male','female', 'not specify']);
            $table->enum('marital_status',['single','married', 'others']);
            $table->enum('role',['MD','COO', 'CFO','HBDM','BDM','DRO','BDO','PM','TSO','SO','CMO','HRM'])->nullable();
            $table->softDeletes();

           // $table->string('next_of_kin_name')->nullable();
           // $table->string('next_of_kin_email')->nullable();
           // $table->string('next_of_kin_phone')->nullable();
           // $table->text('next_of_kin_address')->nullable();
            $table->timestamps();


        });
        Schema::table('staff_profiles', function($table){
            $table->foreign('user_id')->references('id')->on('users');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_profiles');
    }
}
