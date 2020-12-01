<?php


namespace App\Library\Twitter;


class TwitterRealApi implements  TwitterInterface
{

    private  $twitterUserId;

    /**
     * TwitterReal constructor.
     * @param int $twitterUserId
     */
    public function __construct($twitterUserId)
    {
        $this->twitterUserId = $twitterUserId;
    }

    public function setUserName($twitterUserId): void
    {
        $this->twitterUserId = $twitterUserId;
    }

    public function getTweets()
    {
        // TODO: Implement getTweets() method.
    }


}
