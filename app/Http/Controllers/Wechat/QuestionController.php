<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\WechatController;
use App\Models\Question;
use App\Models\Activity;
use App\Policies\ActivityPolicy;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Test;
use App\Models\Answer;
use Auth;

class QuestionController extends WechatController
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Activity $activity)
    {
        #存储用户openid
        $user = User::firstOrNew([
            'openid' => $request->openid,
        ]);

        $expiresAt = Carbon::now()->addMinutes(60);
        Cache::put('answers', [], $expiresAt);
        Cache::put('activity', $activity, $expiresAt);

        #随机抽取题卷
        $test = Test::where('status', '=', 1)
                        ->inRandomOrder()
                        ->first();

        $activityPolicy = new ActivityPolicy();
        $judge = $activityPolicy->judgeJoinActivity($activity, $user, $test);

        $message = $judge['mess'];
        $state = $judge['state'];

        if ($state) {
            #缓存--题目ids
            Cache::put('questions', $test, $expiresAt);
        }
        $now = $test->question_ids;
        return view('wechat/question/index', compact('message', 'state', 'now', 'activity'));
    }

    /**
     * 当前页和下一页
     * @return [type] [description]
     */
    private function upturn()
    {
        $questions = Cache::get('questions');
        $answers = Cache::get('answers');
        $question = $questions->question_ids;
        $count = count($question);
        $key = count($answers);

        if ($count > 0 && $key + 1 <= $count) {
            $now = $question[$key];
            $next = isset($question[$key + 1]) ? $question[$key + 1] : null;
        } else {
            $now = null;
            $next = null;
        }

        $activity = ['now' => $now, 'next' => $next, 'key' => $key, 'count' => $count];

        return $activity;
    }

    /**
     * 答题
     * @param  Question $question [description]
     * @return [type]             [description]
     */
    public function answer(Question $question)
    {
        $page = $this->upturn();

        if ($page['now'] === null) {
            $questions = Cache::get('questions');
            $test = $questions['id'];
            return redirect()->route('test', $test);
        }
        if ($question->id != $page['now']) {
            return redirect()->route('answer', $page['now']);
        }
        #选项
        $answers = array_map(function ($val) {
            return array_merge(explode('.', trim($val)), ['']);
        }, explode("\r\n", str_replace(";", '', $question->options)));

        return view('wechat/question/answer', compact('question', 'answers'));
    }

    /**
     * 答题反馈
     * @param  Request  $request  [description]
     * @param  Question $question [description]
     * @return [type]             [description]
     */
    public function change(Request $request, Question $question)
    {
        #答案对错
        $judge = $request->answer == $question->corrent ? true : false;
        $questions = Cache::get('questions');
        $test = $questions['id'];

        $page = $this->upturn();

        $answer = $request->answer == $question->corrent ? 1 : 0;

        $answers = Cache::get('answers');

        #缓存
        $answers[] = $answer;
        $expiresAt = Carbon::now()->addMinutes(60);
        Cache::put('answers', $answers, $expiresAt);
        $this->upturn();

        if ($page['next'] === null) {
            #答题记录
            $count = 0;
            foreach ($answers as $val) {
                if ($val == 1) {
                    $count++;
                }
            }

            $score = number_format($count / count($answers) * 100, 2);

            $activity = Cache::get('activity');

            #添加数据
            Answer::create([
                'user_id' => Auth::user()->id,
                'test_id' => Cache::get('questions')->id,
                'activity_id' => $activity->id,
                'answers' => implode(',', $answers),
                'score' => $score,
            ]);
            return response()->json(['judge' => $judge, 'status' => 1, 'test' => $test], 201);
        }

        return response()->json(['judge' => $judge, 'status' => 1, 'question' => $page['next']], 201);
    }

    public function grade(Request $request, Test $test)
    {
        $log = Answer::where('user_id', Auth::user()->id)->where('test_id', $test->id)->orderBy('id', 'desc') ->first();
        $answers = array();
        $count = $log->score;
        foreach (explode(',', $log->answers) as $key => $val) {
            $answers[$key]['id'] = $key + 1;
            $answers[$key]['status'] = $val == 1 ? true : false;
        }
        $activity = Cache::get('activity');
        $url = '';
        if ($count >= $activity->getScore) {
            $url = route('turntable', array('activity' => $activity->id, 'answer' => $log->id));
        }
        return view('wechat/question/result', compact('count', 'answers', 'url'));
    }
}
