<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationToSupportGroupsTable extends Migration
{
    public function up()
    {
        Schema::table('support_groups', function (Blueprint $table) {
            $table->string('location')->nullable(); // Assuming some groups might be virtual
        });
    }

    public function down()
    {
        Schema::table('support_groups', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
}
