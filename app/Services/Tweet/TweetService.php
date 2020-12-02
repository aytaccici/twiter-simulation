<?php


namespace App\Services\Tweet;

use App\Contracts\TweetContract;
use App\Library\Twitter\TwitterAdapter;
use App\Library\Twitter\TwitterMockApi;
use App\Repositories\TweetRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TweetService
{

    /**
     * @var TweetRepository
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
     * @return int|null
     */
    private function getLoggedInUserId()
    {
        return Auth::guard('api')->user()->twitter_id ?? null;
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



    private function getTweetsFromApi(int $twitterUserId)
    {
        $api            = new TwitterMockApi($twitterUserId);
        $twitterAdapter = new TwitterAdapter($api);
        return $twitterAdapter->getTweets();
    }


    /**
     * @return mixed
     */
    public function getUserTweets(){
        return $this->twitterContract->findUserTweets((int)$this->getLoggedInUserId());
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws AuthorizationException | ModelNotFoundException
     */
    public function publishTweet(Request $request){

        $tweet = $this->twitterContract->find( (int) $request->get('id'));


        if (!$tweet){
            throw new ModelNotFoundException();
        }

        $userCanUpdate = Gate::forUser(Auth::guard('api')->user())->allows('update',$tweet);

        if (!$userCanUpdate){
            throw new AuthorizationException();
        }

        $attributes = array(
            'is_publish' => true
        );

        if ($request->get('content')){
            $attributes['content'] = $request->get('content');
        }

        //update islemi gercekleştiriliyor
        $this->twitterContract->update($attributes,$tweet->id);

        return $tweet->fresh();
    }


}
