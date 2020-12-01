<?php


namespace App\Services\Tweet;

use App\Contracts\TweetContract;
use App\Library\Twitter\TwitterAdapter;
use App\Library\Twitter\TwitterMockApi;
use Illuminate\Support\Facades\Auth;

class TweetService
{

    /**
     * @var TweetContract
     */
    protected $twitterContract;

    /**
     * TweetService constructor.
     * @param TweetContract $twitterContract
     */
    public function __construct(TweetContract $twitterContract)
    {
        $this->twitterContract = $twitterContract;
    }


    /**
     * @return bool
     */
    public function moveTweets()
    {
        $tweets = $this->getTweetsFromApi((int)$this->getLoggedInUserId());


        $movedTweets = $this->getAlreadyMovedTweets();

        foreach ($tweets as $tweet) {
            if (!in_array($tweet->getId(), $movedTweets)) {
                $this->addTweetsToDatabase($tweet->toArray());
            }
        }

        return true;
    }


    /**
     * @return array
     */
    private function getAlreadyMovedTweets()
    {
        return $this->twitterContract->findMovedTweetsForUser((int)$this->getLoggedInUserId())
            ->pluck('twit_id')
            ->toArray();
    }

    /**
     * @param $tweet
     * @return mixed
     */
    private function addTweetsToDatabase($tweet)
    {
        return $this->twitterContract->store($tweet);
    }

    /**
     * @return |null
     */
    private function getLoggedInUserId()
    {
        return $twitterUserId = Auth::guard('api')->user()->twitter_id ?? null;
    }


    private function getTweetsFromApi(int $twitterUserId)
    {
        $api            = new TwitterMockApi($twitterUserId);
        $twitterAdapter = new TwitterAdapter($api);
        return $twitterAdapter->getTweets();
    }


}
