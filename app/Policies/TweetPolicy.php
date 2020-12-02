<?php

namespace App\Policies;

use App\Models\Tweet;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TweetPolicy
{
    use HandlesAuthorization;


    public function update(User $user, Tweet $tweet)
    {
        return $user->twitter_id === $tweet->user_id;
    }
}
