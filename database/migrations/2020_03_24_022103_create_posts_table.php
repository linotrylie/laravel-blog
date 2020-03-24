<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePostsTable.
 */
class CreatePostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(1)->comment('文章作者');
            $table->integer('category_id')->default(0)->comment('文章所属分类id');
            $table->string('title',200)->default('')->comment('文章标题');
            $table->longText('text')->comment('文章内容');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('type',16)->default('post')->comment('类型 post文章 page页面');
            $table->string('password',200)->default('')->comment('密码');
            $table->integer('views')->default(0)->comment('文章查看次数');
            $table->integer('comments')->default(0)->comment('文章评论数');
            $table->integer('shares')->default(0)->comment('文章分享数');
            $table->integer('follows')->default(0)->comment('文章点赞数');
            $table->tinyInteger('status')->default(1)->comment('删除 0删除');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}
}
