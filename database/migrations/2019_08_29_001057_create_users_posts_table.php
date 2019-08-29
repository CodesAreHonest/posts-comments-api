<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('users_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users');

            $table->foreign('post_id')->references('id')
                ->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_posts', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->dropForeign(['post_id']);
            $table->dropColumn('post_id');
        });

        Schema::dropIfExists('users_posts');
    }
}
