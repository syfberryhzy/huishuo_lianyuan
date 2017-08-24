<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Activity;
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

    public function judge(Activity $activity)
    {
        $carbon = new Carbon();
        $dt = Carbon::now('Asia/Shanghai');

        $first = Carbon::parse($activity->start_time, 'Asia/Shanghai');
        $second = Carbon::parse($activity->end_time, 'Asia/Shanghai');

        $judegWeek = in_array($dt->dayOfWeek, $activity->activity_week) || $dt->dayOfWeek == $activity->activity_week;
        $result =  $first->lte($dt) && $dt->gte($second) && $judegWeek;
        return  $result;
    }
}
