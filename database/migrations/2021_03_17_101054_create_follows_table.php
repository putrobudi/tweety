<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // You see that we're not following Laravel pivot table naming convention
        // Because if we do here, it'd be user_user and it's funny. So you must 
        // make adjustment when defining the relationships in the Model.
        Schema::create('follows', function (Blueprint $table) {
            $table->primary(['user_id', 'following_user_id']);
            $table->foreignId('user_id');
            $table->foreignId('following_user_id');
            $table->timestamps();
            
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            
            $table->foreign('following_user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
