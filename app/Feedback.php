<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $primaryKey = 'feedbackID';
    protected $table = "feedbacks";

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function dislikes()
    {
        return $this->hasMany('App\Dislike');
    }
}
