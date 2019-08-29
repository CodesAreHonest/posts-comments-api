<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPostsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('users_posts_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_posts_id');
            $table->unsignedBigInteger('comments_id');
            $table->timestamps();

            $table->foreign('users_posts_id')->references('id')
                ->on('users_posts');
            $table->foreign('comments_id')->references('id')
                ->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users posts_comments', function (Blueprint $table) {
            $table->dropForeign(['users_posts_id']);
            $table->dropColumn('users_posts_id');

            $table->dropForeign(['comments_id']);
            $table->dropColumn('comments_id');
        });
        Schema::dropIfExists('users_posts_comments');
    }
}
