<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHomeMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name',50)->default('')->comment('菜单名称');
            $table->integer('parent_id')->default(0)->comment('父级id');
            $table->string('router',191)->default('')->comment('菜单地址');
            $table->integer('sort')->default(0)->comment('菜单排序');
            $table->integer('status')->default(1)->comment('是否删除');
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
        Schema::dropIfExists('home_menus');
    }
}
