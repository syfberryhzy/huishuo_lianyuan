<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\WechatController;
use App\Models\Activity;

class TurntableController extends WechatController
{
    public function index()
    {
        return view('wechat/turntable/index');
    }

    public function store(Request $request, Activity $activity)
    {
        $rotate = rand(1, 360) + rand(5, 10) * 360;
        $prize = ['id' => 1, 'name' => '100元话费', 'status' => '1'];

        return response()->json(['rotate' => $rotate, 'prize' => $prize], 200);
    }

    public function award()
    {
        return view('wechat/turntable/award');
    }
}
