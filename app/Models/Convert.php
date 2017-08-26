<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Award;
use App\Models\Lottery;

class Convert extends Model
{
    protected $fillable = ['user_id', 'lottery_id', 'username', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }
}
