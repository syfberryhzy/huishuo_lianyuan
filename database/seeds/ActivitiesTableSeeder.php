<?php

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activity = Activity::firstOrNew([
            'title' => '转盘抽奖',
        ]);
        if (!$activity->exists) {
            $activity->fill([
                'start_time'     => "2017-08-13 00:00:00",
                'end_time'       => '2017-12-13 00:00:00',
                'getScore'       => "60.00",
                'activity_week'  => ['6', '1', '2', '3', '4', '5'],
                'rule'  => "1.	关注“分好啦”微信服务号，回复关键词：有奖答题或点击微信号底部自定义菜单“我要答题抽奖”参与活动，每周6有1次抽奖机会，祝你好运！
2.	每人每周六可通过垃圾分类有奖答题免费抽奖1次，抽奖机会当天有效
3.	活动中奖结果均以页面显示为准，中奖者请与中奖24小时内点击领取奖品，中奖商品
4.	凡中奖客户后台截图回复手机号，工作人员为您进行奖品兑换
5.    奖项设置： 一等奖：50元话费X4；二等奖：1G流量套餐x10；三等奖：垃圾分类500积分x15",
                'image'          => "image/answer_bg.png",
                'status'         => 1
            ])->save();
        }
    }
}
