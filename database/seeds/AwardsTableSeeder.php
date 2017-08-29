<?php

use Illuminate\Database\Seeder;
use App\Models\Award;

class AwardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $award = Award::firstOrNew([
            'title' => '一等奖：50元话费',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 1,
                'end_probability'       => 4,
                'number'  => 4,
                'is_lottery'          => 1,
                'header'          => '分好啦抽奖答题，小朋友快来玩呀',
                'des'          => '太幸运了，我在联运环境抽中了一等奖：50元话费，你也一起来参与吧。',
                'image'          => ''
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '不要灰心',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 30,
                'end_probability'       => 3030,
                'number'  => 0,
                'is_lottery'          => 0,
                'header'          => '分好啦抽奖答题，小朋友快来玩呀',
                'des'          => '好可惜，我在联运环境差一点就抽中一等奖，你也一起来参与吧。',
                'image'          => ''
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '二等奖：1G流量套餐',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 5,
                'end_probability'       => 14,
                'number'  => 10,
                'is_lottery'          => 1,
                'header'          => '分好啦抽奖答题，小朋友快来玩呀',
                'des'          => '太幸运了，我在联运环境抽中了二等奖：1G流量套餐，你也一起来参与吧。',
                'image'          => "image/20170616191443_889.png",
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '谢谢参与',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 31,
                'end_probability'       => 6030,
                'number'  => 0,
                'is_lottery'          => 0,
                'header'          => '分好啦抽奖答题，小朋友快来玩呀',
                'des'          => '好可惜，我在联运环境差一点就抽中一等奖，你也一起来参与吧。',
                'image'          => "image/20170616191443_889.png",
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '三等奖：垃圾分类500积分',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 15,
                'end_probability'       => 29,
                'number'  => 15,
                'is_lottery'          => 1,
                'header'          => '分好啦抽奖答题，小朋友快来玩呀',
                'des'          => '太幸运了，我在联运环境抽中了三等奖：垃圾分类500积分，你也一起来参与吧。',
                'image'          => "image/20170616191443_889.png",
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '要加油哦',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 6031,
                'end_probability'       => 10000,
                'number'  => 0,
                'is_lottery'          => 0,
                'header'          => '分好啦抽奖答题，小朋友快来玩呀',
                'des'          => '好可惜，我在联运环境差一点就抽中一等奖，你也一起来参与吧。',
                'image'          => "image/20170616191443_889.png",
            ])->save();
        }
    }
}