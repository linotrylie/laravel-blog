<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class HomeMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'menu_name'=>'首页',
                'parent_id'=>0,
                'router'   => '/',
                'sort'     => 1
            ],
            [
                'menu_name'=>'归档',
                'parent_id'=>0,
                'router'   => '/record',
                'sort'     => 2
            ],
            [
                'menu_name'=>'分类',
                'parent_id'=>0,
                'router'   => '/category',
                'sort'     => 3
            ],
            [
                'menu_name'=>'php',
                'parent_id'=>3,
                'router'   => '/category/php',
                'sort'     => 4
            ],
            [
                'menu_name'=>'laravel',
                'parent_id'=>3,
                'router'   => '/category/laravel',
                'sort'     => 5
            ],
        ];
        DB::table('home_menus')->insert($data);
    }
}
