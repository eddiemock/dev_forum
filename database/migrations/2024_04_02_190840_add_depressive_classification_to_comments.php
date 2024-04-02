<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepressiveClassificationToComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('topic');
            $table->dateTime('scheduled_at');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('zoom_link')->nullable();
            $table->timestamps();
        });
        ;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            //
        });
    }
}
