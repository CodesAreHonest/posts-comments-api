<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLikePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('users_like_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_posts_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('users_posts_id')->references('id')->on('users_posts');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_like_posts', function (Blueprint $table) {
            $table->dropForeign(['users_posts_id']);
            $table->dropColumn('users_posts_id');

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('users_like_posts');
    }
}
