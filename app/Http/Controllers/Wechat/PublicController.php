<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\WechatController;
use App\Models\activity;

class PublicController extends WechatController
{
    public $defaultContent  = '1.	关注“分好啦”微信服务号，回复关键词：有奖答题或点击微信号底部自定义菜单“我要答题抽奖”参与活动，每周6有1次抽奖机会，祝你好运！
<br>2.	每人每周六可通过垃圾分类有奖答题免费抽奖1次，抽奖机会当天有效
<br>3.	活动中奖结果均以页面显示为准，中奖者请与中奖24小时内点击领取奖品，中奖商品
<br>4.	凡中奖客户后台截图回复手机号，工作人员为您进行奖品兑换
<br>5.奖项设置：
一等奖：50元话费X4；二等奖：1G流量套餐x10；三等奖：垃圾分类500积分x15';

    public function rules(Request $request, Activity $activity)
    {
        $content = $activity->rule;
        $content = !$content ? $this->defaultContent : str_replace("\r\n", '<br/>', $content);
        return view('wechat/question/rules', compact('content'));
    }
}
