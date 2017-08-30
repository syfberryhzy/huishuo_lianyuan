<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Test;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Activity;
use App\Models\Answer;
use Carbon\Carbon;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function judgeJoinActivity(Activity $activity, User $user, Test $tests)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://www.fhlts.com/game/getUserInfo?openId=' . $user->openid);

        if ($res->getStatusCode() === 200) {
            $info = json_decode($res->getBody()->getContents(), true);

            $user->name = $info['nickname'] ? $info['nickname'] : '';
            $user->save();

            if ($info['subscribe'] !== 1) {
                return array('mess' => ['请先关注', '分好啦公众账号'], 'state' => false);
            }

            if ($info['bind'] !== 1) {
                return array('mess' => ['请先绑定', '分好啦平台账号'], 'state' => false);
            }
        } else {
            return array('mess' => ['获取用户', '个人信息失败，请重试'], 'state' => false);
        }

        \Auth::login($user, true);

        $state = $this->judgeActivity($activity);

        if ($state) {
            $state = $this->judgeWeek($activity);
            if ($state) {
                $state = !empty($tests) ? true : false;
                $mess[0] = $state ? '游戏马上开始' : '题库正在更新';
                $mess[1] = $state ? '要细心答题哦' : '耐心等待哦...';
                $res = $this->judgeHasBeenInvolved($activity, $user);
                if ($res->toArray()) {
                    //$mess[0] = '你本次已经参与';
                    //$mess[1] = '请于每周六，参加本活动';
                    //$state = false;
                }
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

    private function judgeActivity(Activity $activity)
    {
        $carbon = new Carbon();
        $dt = Carbon::now('Asia/Shanghai');
        $first = Carbon::parse($activity->start_time, 'Asia/Shanghai');
        $second = Carbon::parse($activity->end_time, 'Asia/Shanghai');
        $result =  $first->lte($dt) &&$second->gte($dt);
        return  $result;
    }

    private function judgeWeek(Activity $activity)
    {
         $carbon = new Carbon();
         $dt = Carbon::now('Asia/Shanghai');
         $result = in_array(($dt->dayOfWeek + 1), $activity->activity_week) || ($dt->dayOfWeek + 1) == $activity->activity_week;
         return  $result;
    }

    private function judgeHasBeenInvolved($activity, $user)
    {
        $answer = Answer::where([
            'activity_id' => $activity->id,
            'user_id' => $user->id,
        ])
        ->where('created_at', '>=', Carbon::now()->startOfWeek())
        ->where('created_at', '<=', Carbon::now()->endOfWeek())
        ->get();
        return $answer;
    }
}
