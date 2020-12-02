<?php


namespace App\Repositories;


use App\Contracts\TweetContract;
use App\Models\Tweet;

class TweetRepository extends BaseRepository implements TweetContract
{

    /**
     * @return string
     */
    protected function entity()
    {
        return Tweet::class;
    }


    /**
     * @param int $userId
     * @return mixed
     */
    public function findMovedTweetsForUser(int $userId){
        return $this->entity->where('user_id',$userId)
            ->get();
    }


    /**
     * @param int $userId
     * @return mixed
     */
    public function findUserTweets(int $userId){
        return $this->entity
            ->where('user_id',$userId)
            ->published()
            ->latest()
            ->paginate(config('app.paginate_limit'));
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function findUserTweetsWithNonPublished(int $userId){
        return $this->entity
            ->where('user_id',$userId)->get();
    }


    /**
     * @param string $userName
     * @return mixed
     */
    public function findUserTweetsByUserName(string $userName){

        return $this->entity
            ->whereHas('user',function ($query) use ($userName){
                return $query->where('twitter',$userName);
            })
            ->published()
            ->latest()
            ->paginate(config('app.paginate_limit'));
    }


    /**
     * @return mixed
     */
    public function getAllTweetsOrderByLatest(){
        return $this->entity->published()
            ->latest()
            ->paginate(config('app.paginate_limit'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find(int $id){

        return $this->entity
            ->where('id',$id)
            ->first();
    }
}
