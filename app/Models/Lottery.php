<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Award;

class Lottery extends Model
{
    protected $fillable = ['user_id','activity_id','answer_id', 'award_id','is_winning','is_convert'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function award()
    {
        return $this->belongsTo(Award::class);
    }


}
