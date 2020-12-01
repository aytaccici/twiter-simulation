<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $guarded=[];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopePublished($query)
    {
        return $query->where('is_publish',true);
    }

}
