<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //public function up()
    //{
      //Schema::create('reports', function (Blueprint $table) {
       //     $table->id();
   //         $table->unsignedBigInteger('user_id');
   //         $table->text('reason');
    //        $table->morphs('reportable'); // Polymorphic relation to allow reporting different models (e.g., posts, comments)
   //         $table->timestamps();
   //     
   //         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
   //     });
    //    
   // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
