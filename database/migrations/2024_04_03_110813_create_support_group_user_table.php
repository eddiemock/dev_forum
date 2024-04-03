<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   // public function up()
  //  {
  //      Schema::create('support_group_user', function (Blueprint $table) {
  //          $table->id();
  //          $table->unsignedBigInteger('support_group_id'); // Use unsignedBigInteger
  //          $table->unsignedBigInteger('user_id'); // Use unsignedBigInteger
  //      
  //          $table->foreign('support_group_id')->references('id')->on('support_groups')->onDelete('cascade');
  //          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
  //      
  //          $table->timestamps();
  //      });
  //      
  //  }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_group_user');
    }
}
