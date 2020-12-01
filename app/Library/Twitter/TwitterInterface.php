<?php


namespace App\Library\Twitter;


interface  TwitterInterface
{

    /**
     * @param $twitterUserId
     */
    public  function setUserName($twitterUserId):void;


    /**
     * @return mixed
     */
    public  function getTweets();
}
