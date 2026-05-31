<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Plot_id');
            $table->unsignedBigInteger('plot_type_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('price',12,2)->default(0.00);
            $table->string('land_id')->nullable();
            $table->string('no_of_plots')->default(0);
            $table->string('sqm')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',['sold','unsold','pending'])->default('unsold');

            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('plots', function($table){
            $table->foreign('plot_type_id')->references('id')->on('plot_types');     
            $table->foreign('product_id')->references('id')->on('products');   
          
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plots');
    }
}
