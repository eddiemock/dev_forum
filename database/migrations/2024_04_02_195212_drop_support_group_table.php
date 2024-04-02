<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSupportGroupTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('support_groups');
    }

    public function down()
    {
        Schema::create('support_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('topic');
            $table->dateTime('scheduled_at');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            // Add back any other fields you had previously
            $table->timestamps();
        });
    }
}
