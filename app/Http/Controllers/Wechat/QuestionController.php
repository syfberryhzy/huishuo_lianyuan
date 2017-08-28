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
        if (!$user->exists) {
            // http://www.fhlts.com/game/getUserInfo?openId=oZ14ywiqJ8kkU5rly07UdccxLz58

            $user->fill([
                'name' => '',
            ])->save();
        }

        Auth::login($user, true);
        // Auth::loginUsingId($user->id);
        // dd(Auth::user());

        $expiresAt = Carbon::now()->addMinutes(60);
        Cache::put('answers', [], $expiresAt);
        Cache::put('activity', $activity, $expiresAt);

        #随机抽取题卷
        $test = Test::where('status', '=', 1)
                        ->inRandomOrder()
                        ->first();
        $judge = $this->judge($test, $activity);
        $message = $judge['mess'];
        $state = $judge['state'];
        if (true) {
            #缓存--题目ids
            Cache::put('questions', $test, $expiresAt);
        }
        $now = $test->question_ids;
        return view('wechat/question/index', compact('message', 'state', 'now', 'activity'));
    }
    /**
     * #策略
     * @return [type] [description]
     */
    public function judge($tests, $activity)
    {
        #策略
        $activityPolicy = new ActivityPolicy();
        $state = $activityPolicy->judgeActivity($activity);

        if ($state) {
            $state = $activityPolicy->judgeWeek($activity);
            if ($state) {
                $state = !empty($tests) ? true : false;
                $mess[0] = $state ? '游戏马上开始' : '题库正在更新';
                $mess[1] = $state ? '要细心答题哦' : '耐心等待哦...';
            } else {
                $mess[0] = '请于每周六';
                $mess[1] = '参加本活动';
            }
        } else {
            $mess[0] = '活动已结束';
            $mess[1] = '敬请期待下一期！';
        }
        return array('mess' => $mess, 'state' => $state);
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
            #添加数据
            Answer::create([
                'user_id' => Auth::user()->id,
                'test_id' => Cache::get('questions')->id,
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
        // dd($activity);
        $url = '';
        if ($count >= $activity->getScore) {
            $url = route('turntable', array('activity' => $activity->id, 'answer' => $log->id));
        }
        return view('wechat/question/result', compact('count', 'answers', 'url'));
    }
}
