<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tweet_id')->constrained()->onDelete('cascade');
            # you can have two different columns of liked and disliked or treat the twos as seperate entities in different tables
            # or just simple one tinyint column
            $table->boolean('liked'); // 0 or 1 

            $table->timestamps();

            $table->unique(['user_id', 'tweet_id']); // does this only put constraint when executing through Laravel?
            // Because I can add duplicate user_id and tweet_id directly in database.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
