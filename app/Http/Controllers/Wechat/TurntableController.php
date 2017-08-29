<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\WechatController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Activity;
use App\Models\Answer;
use App\Models\Lottery;
use App\Models\Award;
use App\Models\Convert;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Auth;

class TurntableController extends WechatController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, Activity $activity, Answer $answer)
    {
        $expiresAt = Carbon::now()->addMinutes(60);
        Cache::put('user_answer', $answer, $expiresAt);

        $question = $activity->id;
        $awards = Award::where('activity_id', $activity->id)->orderBy('id', 'asc')->get();

        #抽奖转盘
        $datas = $this->turnTable($awards);
        $restaraunts =  $datas['restaraunts'];
        $colors = $datas['colors'];

        $logs = Lottery::with('user', 'award')->where('is_winning', 1)->limit(3)->orderBy('created_at', 'desc')->get();

        #分享功能
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://www.fhlts.com/share?url=' . config('app.url') . $request->getRequestUri());
        if ($res->getStatusCode() == 200) {
            $jssdk = json_decode($res->getBody()->getContents());
            $jsApiList = array('onMenuShareTimeline', 'onMenuShareAppMessage');
        }

        return view('wechat/turntable/index', compact('question', 'restaraunts', 'colors', 'logs', 'jssdk', 'jsApiList'));
    }

    #抽奖转盘
    public function turnTable($awards)
    {
        $awards = collect($awards)->pluck('title');
        foreach ($awards as $key => $val) {
            $colors[] = $key % 2 == 0 ? "#ffeb8c" : "#ffd570";
        }
        return array('restaraunts' => $awards, 'colors' => $colors);
    }

    /**
     * 抽奖算法
     * @param  [type] $activity [description]
     * @return [type]           [description]
     */
    public function limitNumber($activity)
    {
        // $probability = rand(1, 10000);
        $probability = rand(1, 20);
        $prize = Award::where('activity_id', $activity->id)
                        ->where('start_probability', '<=', $probability)
                        ->where('end_probability', '>=', $probability)
                        ->orderBy('id', 'asc')
                        ->firstOrFail();
        $number = $prize->id;
        $count = Lottery::where('activity_id', $activity->id)
                ->where('award_id', $number)
                ->where('created_at', '>=', Carbon::now()->startOfWeek())
                ->where('created_at', '<=', Carbon::now()->endOfWeek())
                ->count();
        if ($prize->is_lottery == 1 && $prize->number <= $count) {
            $this->limitNumber($activity);
        } else {
            return array($prize, $number);
        }
    }

    public function store(Request $request, Activity $activity)
    {
        #是否已抽奖
        $answer = Cache::get('user_answer');
        try {
            $lottery = Lottery::where('user_id', Auth::user()->id)->where('answer_id', $answer->id)->firstOrFail();
            if ($lottery->is_winning == 1 && $lottery->is_convert == 0 ) {
                # 中奖还未兑换
                $prize = Award::find($lottery->award_id);
                $number = $prize->id;
            } elseif ($lottery->is_winning == 1 && $lottery->is_convert == 1) {
                # 中奖兑换
                return response()->json(['rotate' => 0], 200);
            } elseif ($lottery->is_winning == 0) {
                # 未中奖
                $prize = Award::find($lottery->award_id);
                $number = $prize->id;
            }
        } catch (ModelNotFoundException $e) {
            $datas = $this->limitNumber($activity);
            $prize = $datas[0];
            $number = $datas[1];
            #添加抽奖纪录
            $lottery = Lottery::create([
                'user_id' => Auth::user()->id,
                'activity_id' => $activity->id,
                'award_id' => $prize->id,
                'answer_id' => $answer->id,
                'is_winning' => $prize->is_lottery,
                'is_convert' => 0
            ]);
        }
        #奖品项
        $awards = Award::select('id')->where('activity_id', $activity->id)->orderBy('id', 'asc')->get();
        #奖品组
        $numbers = collect($awards)->pluck('id')->toArray();
        rsort($numbers);
        $index = array_search($number, $numbers);
        #旋转角度
        $rotate = rand(360 / count($awards) * $index, 360 / count($awards) * ($index + 1)) + rand(5, 10) * 360;


        return response()->json(['rotate' => $rotate, 'prize' => $prize, 'index' => $index, 'numbers' => $numbers, 'lottery' => $lottery->id], 200);
    }

    /**
     * 兑奖
     * @param  Request $request [description]
     * @param  Lottery $lottery [description]
     * @return [type]           [description]
     */
    public function convert(Request $request, Lottery $lottery)
    {

        #是否已兑奖
        try {
            $log = Convert::where('user_id', Auth::user()->id)->where('lottery_id', $lottery->id)->firstOrFail();
            return response()->json(['status' => 0], 201);
        } catch (ModelNotFoundException $e) {
        }
        if ($lottery->is_convert == 1)
            return response()->json(['status' => 0], 201);
        #添加兑奖纪录
        $convert = Convert::create([
            'user_id' => Auth::user()->id,
            'lottery_id' => $lottery->id,
            'username' => $request->username,
            'phone' => $request->phone
        ]);
        #修改兑奖状态
        $lottery->is_convert = 1;
        $lottery->save();
        return response()->json(['status' => 1], 201);
    }

    public function award()
    {
        $logs = Convert::with('lottery.award')
                        ->where('user_id', Auth::user()->id)
                        ->orderBy('created_at', 'desc')->get();
                        // dd($logs);
        return view('wechat/turntable/award', compact('logs'));
    }
}