<?php


namespace App\Library\Twitter;


class TwitterAdapter implements TweetApiInterface
{

    /**
     * @var TwitterInterface
     */
    private  $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function getTweets()
    {
        return $this->api->getTweets();
    }

}
