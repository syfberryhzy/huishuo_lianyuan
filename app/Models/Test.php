<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Test extends Model
{
    public function setQuestionIdsAttribute($options)
    {
        if (is_array($options)) {
            $this->attributes['question_ids'] = implode(',', $options);
        }
    }

    public function getQuestionIdsAttribute($options)
    {
        return explode(',', $options);
    }
}
