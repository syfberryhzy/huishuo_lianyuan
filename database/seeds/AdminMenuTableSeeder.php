<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Index',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 3,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 5,
                'title' => 'Permission',
                'icon' => 'fa-user',
                'uri' => 'auth/permissions',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 8,
                'title' => 'Helpers',
                'icon' => 'fa-gears',
                'uri' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 8,
                'order' => 9,
                'title' => 'Scaffold',
                'icon' => 'fa-keyboard-o',
                'uri' => 'helpers/scaffold',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 8,
                'order' => 10,
                'title' => 'Database terminal',
                'icon' => 'fa-database',
                'uri' => 'helpers/terminal/database',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 8,
                'order' => 11,
                'title' => 'Laravel artisan',
                'icon' => 'fa-terminal',
                'uri' => 'helpers/terminal/artisan',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 0,
                'order' => 12,
                'title' => '活动',
                'icon' => 'fa-gamepad',
                'uri' => '/game',
                'created_at' => '2017-08-17 19:03:13',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 12,
                'order' => 14,
                'title' => '答题',
                'icon' => 'fa-pencil-square',
                'uri' => '/game/question',
                'created_at' => '2017-08-17 19:11:44',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 13,
                'order' => 15,
                'title' => '题库',
                'icon' => 'fa-cube',
                'uri' => '/game/question/questions',
                'created_at' => '2017-08-17 19:13:37',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 13,
                'order' => 16,
                'title' => '题卷',
                'icon' => 'fa-cubes',
                'uri' => '/game/question/tests',
                'created_at' => '2017-08-17 19:14:28',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 12,
                'order' => 18,
                'title' => '大转盘',
                'icon' => 'fa-circle-thin',
                'uri' => '/game/circle',
                'created_at' => '2017-08-17 19:16:35',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 16,
                'order' => 19,
                'title' => '列表',
                'icon' => 'fa-list',
                'uri' => '/game/circle/activities',
                'created_at' => '2017-08-17 19:18:34',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 16,
                'order' => 20,
                'title' => '奖品',
                'icon' => 'fa-gift',
                'uri' => '/game/circle/awards',
                'created_at' => '2017-08-17 19:19:45',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 16,
                'order' => 21,
                'title' => '抽奖',
                'icon' => 'fa-clock-o',
                'uri' => '/game/circle/lotteries',
                'created_at' => '2017-08-17 19:22:07',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => 16,
                'order' => 22,
                'title' => '兑奖',
                'icon' => 'fa-bars',
                'uri' => '/game/circle/converts',
                'created_at' => '2017-08-17 19:23:31',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            20 => 
            array (
                'id' => 21,
                'parent_id' => 13,
                'order' => 17,
                'title' => '记录',
                'icon' => 'fa-hand-paper-o',
                'uri' => '/game/question/answers',
                'created_at' => '2017-08-17 19:27:36',
                'updated_at' => '2017-08-18 09:06:31',
            ),
            21 => 
            array (
                'id' => 22,
                'parent_id' => 12,
                'order' => 13,
                'title' => '用户',
                'icon' => 'fa-user',
                'uri' => '/game/users',
                'created_at' => '2017-08-17 19:29:27',
                'updated_at' => '2017-08-18 09:06:31',
            ),
        ));
        
        
    }
}
