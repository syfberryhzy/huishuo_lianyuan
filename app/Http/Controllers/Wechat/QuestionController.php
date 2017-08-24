<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\WechatController;
use App\Models\Question;
use App\Models\Activity;
use App\Policies\ActivityPolicy;

class QuestionController extends WechatController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Activity $activity)
    {
        $activityPolicy = new ActivityPolicy();
        $state = $activityPolicy->judge($activity);
        $message = $state == true ? '游戏马上开始' : '敬请期待！';
        setCookie('question_ids', $activity->question_ids);
        return view('wechat/question/index', compact('message', 'state', 'activity'));
    }

    public function answer(Question $question)
    {
        $answers = array_map(function ($val) {
            return explode('.', trim($val));
        }, explode("\r\n", str_replace(";", '', $question->options)));

        return view('wechat/question/answer', compact('question', 'answers'));
    }

    public function change(Request $request, Question $question)
    {
        $judge = $request->answer == $question->corrent ? true : fasle;
        return response()->json(['judge' => $judge, 'status' => 1], 201);


        #添加、修改答题记录 ？ 刷新了怎么办 ，重新答题了怎么办
    }

    public function grade(Request $request)
    {
        $count = 90;

        $answers = array(
            ['id' => '1', 'status' => true],
            ['id' => '1', 'status' => true],
            ['id' => '1', 'status' => true],
            ['id' => '1', 'status' => true],
            ['id' => '1', 'status' => true],
            ['id' => '1', 'status' => true],
            ['id' => '1', 'status' => true],
            ['id' => '1', 'status' => true],
            ['id' => '1', 'status' => true],
        );

        return view('wechat/question/result', compact('count', 'answers'));
    }
}
