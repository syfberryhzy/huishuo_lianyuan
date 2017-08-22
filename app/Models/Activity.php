<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function setActivityWeekAttribute($options)
    {
        if (is_array($options)) {
            $this->attributes['activity_week'] = implode(',', $options);
        }
    }

    public function getActivityWeekAttribute($options)
    {
        return explode(',', $options);
    }
}
