<?php


namespace App\Library\Twitter;


use Carbon\Carbon;

class TweetObject
{
    private  $id;
    private  $userId;
    private  $content;
    private  $likeCount;
    private  $reTweetCount;
    private  $createdAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * @param mixed $likeCount
     */
    public function setLikeCount($likeCount): void
    {
        $this->likeCount = $likeCount;
    }

    /**
     * @return mixed
     */
    public function getReTweetCount()
    {
        return $this->reTweetCount;
    }

    /**
     * @param mixed $reTweetCount
     */
    public function setReTweetCount($reTweetCount): void
    {
        $this->reTweetCount = $reTweetCount;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }


    /**
     * @return array
     */
    public function toArray(){

        return [
            'twit_id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'content' => $this->getContent(),
            'liked_count' => $this->getLikeCount(),
            'retweet_count' => $this->getReTweetCount(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getCreatedAt(),
        ];
    }






}
