<?php


namespace App\Library\Twitter;


use Carbon\Carbon;

class TwitterMockApi implements  TwitterInterface
{


    const SERVICE_URL_ROOT='https://5fc665324931580016e3cf4e.mockapi.io/';
    const USERS_PATH ='users';
    const TWEETS_PATH ='tweets';


    private  $twitterUserId;

    /**
     * TwitterReal constructor.
     * @param int $twitterUserId
     */
    public function __construct($twitterUserId)
    {
        $this->twitterUserId = $twitterUserId;
    }


    /**
     * @param $twitterUserId
     */
    public function setUserName($twitterUserId): void
    {
        $this->twitterUserId = $twitterUserId;
    }

    public function getTweets()
    {
        return $this->fetchTweetsFromApi();

    }

    private function fetchTweetsFromApi(){


        $url = self::SERVICE_URL_ROOT.self::USERS_PATH.'/'.$this->twitterUserId.'/'.self::TWEETS_PATH;


        $userTweets =  $this->doRequest($url);

        $tweetsObject = $this->convertResponseToTweetObject($userTweets);

        if (!$tweetsObject){
            throw  new \Exception('Tweet not found for users');
        }

        return $tweetsObject;

    }

    /**
     * @param $url
     * @return mixed
     */
    private function doRequest($url){
        return json_decode(file_get_contents($url),true);
    }

    private function convertResponseToTweetObject(array $userTweets){

       $tweets = array();

        foreach ($userTweets as $tweet) {

            $t = new TweetObject();
            $t->setId($tweet['id']);
            $t->setUserId($tweet['userId']);
            $t->setContent($tweet['content']);
            $t->setLikeCount($tweet['likedCount']);
            $t->setReTweetCount($tweet['retweetCount']);
            $t->setCreatedAt(Carbon::parse($tweet['createdAt'])->format('Y-m-d H:i:s'));

            array_push($tweets,$t);
        }
        return $tweets;
    }




}
