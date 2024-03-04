<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create('discussion_tag', function (Blueprint $table) {
          //  $table->id();
            //$table->unsignedInteger('discussion_id'); // Matched to increments type
            //$table->unsignedBigInteger('tag_id'); // Assuming tags.id is a bigIncrements or similar
            //$table->timestamps();

            //$table->foreign('discussion_id')
              //    ->references('id')
                //  ->on('discussions')
                  //->onDelete('cascade');

            // Make sure the 'tags' table 'id' column type matches this definition
            //$table->foreign('tag_id')
              //    ->references('id')
                //  ->on('tags')
                  //->onDelete('cascade');
        //});
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discussion_tag');
    }
}
