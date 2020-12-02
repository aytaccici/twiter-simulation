<?php

namespace Tests\Feature;

use App\Repositories\TweetRepository;
use App\Repositories\UserRepository;
use Tests\TestCase;

class TweetTest extends TestCase
{


    /**
     * Check whether email is required to login to  list all tweets
     */
    public function test_it_requires_login_to_access_tweets()
    {
        $this->json('GET', 'api/v1/tweets')
            ->assertStatus(403);
    }


    /**
     * A user can list all tweets if they publish
     */
    public function test_it_requires_user_can_show_all_tweets()
    {

        $userRepository = new UserRepository();

        $user = $userRepository->all()->first();

        $this->withHeader('Authorization', 'Bearer ' . $user->api_token)
            ->json('GET', 'api/v1/tweets')->assertStatus(200);
    }


    /**
     * One user can show another user's tweets if they publish
     */
    public function test_it_requires_user_can_show_another_user_tweets()
    {
        $userRepository = new UserRepository();

        $allUsers = $userRepository->all();

        $userOne    = $allUsers->first();
        $secondUser = $allUsers->last();

        $this->withHeader('Authorization', 'Bearer ' . $secondUser->api_token)
            ->json('GET', 'api/v1/tweets/' . $userOne->twitter)->assertStatus(200);
    }


    /**
     *  A user can move own users to db
     */
    public function test_it_requires_user_can_move_tweets()
    {
        $userRepository = new UserRepository();

        $user = $userRepository->all()->first();

        $tweetRepository = new TweetRepository();

        $this->withHeader('Authorization', 'Bearer ' . $user->api_token)
            ->json('POST', 'api/v1/tweets/fetch')->assertStatus(200);

        $tweets = $tweetRepository->findMovedTweetsForUser($user->twitter_id)->count();

        $this->greaterThanOrEqual(1, $tweets);
    }


    /**
     *  A user can move own users to db
     */
    public function test_it_requires_user_can_publish_tweet()
    {
        $userRepository = new UserRepository();

        $user = $userRepository->all()->first();

        $tweetRepository = new TweetRepository();

        $this->withHeader('Authorization', 'Bearer ' . $user->api_token)
            ->json('POST', 'api/v1/tweets/fetch')->assertStatus(200);

        $tweet = $tweetRepository->findUserTweetsWithNonPublished($user->twitter_id)->first();

        $this->withHeader('Authorization', 'Bearer ' . $user->api_token)
            ->json('PUT', 'api/v1/tweets/publish', [
                'id' => $tweet->id,
                'content'  => 'Publish my tweet'
            ])->assertStatus(200);

    }

}
