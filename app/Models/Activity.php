<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['title', 'start_time', 'end_time', 'getScore', 'activity_week', 'image', 'rule', 'status'];
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
