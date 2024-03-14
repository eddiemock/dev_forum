<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCommentsTableForFlaggedColumn extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'is_approved')) {
                $table->dropColumn('is_approved');
            }
            $table->boolean('flagged')->default(false);
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('flagged');
            $table->boolean('is_approved')->default(true);
        });
    }
}
