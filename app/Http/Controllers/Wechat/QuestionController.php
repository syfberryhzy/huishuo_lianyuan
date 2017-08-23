<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\WechatController;
use App\Models\Question;

class QuestionController extends WechatController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('wechat/question/index');
    }

    public function answer()
    {
        $question = array(
            'id' => 1,
            'title' => '下列哪些不属于可回收垃圾？'
        );

        $answers = array(
            ['A', '废铁丝、废铁'],
            ['B', '用过的餐巾纸、茶叶渣'],
            ['C', '玻璃瓶、废塑'],
            ['D', '旧衣服、废报纸']
        );
        return view('wechat/question/answer', compact('question', 'answers'));
    }

    public function change(Request $request, Question $question)
    {
        dd($request, $question);
    }
}
