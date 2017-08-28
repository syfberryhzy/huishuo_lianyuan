<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id', 'test_id', 'score', 'answers', 'activity_id'];
}
