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
        return $this->entity->where('user_id',$userId)->get();
    }


    /**
     * @return mixed
     */
    public function getAllTweetsOrderByLatest(){
        return $this->entity->published()->latest()->paginate(config('app.paginate_limit'));
    }
}
