<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
//    public function up()
//{
    // Create the roles table
 //   Schema::create('roles', function (Blueprint $table) {
 //       $table->id();
 //       $table->string('name')->unique();
 //       $table->timestamps();
 //   });

 //   // Create the role_user table to establish the many-to-many relationship between users and roles
 //   Schema::create('role_user', function (Blueprint $table) {
 //       $table->foreignId('user_id')->constrained()->onDelete('cascade');
 //       $table->foreignId('role_id')->constrained()->onDelete('cascade');
 //       $table->primary(['user_id', 'role_id']); // Set the primary key for the table
  //  });
//}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
