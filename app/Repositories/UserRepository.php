<?php


namespace App\Repositories;


use App\Contracts\UserContract;
use App\User;

class UserRepository extends BaseRepository implements UserContract
{

    /**
     * @return string
     */
    protected function entity()
    {
        return User::class;
    }


    /**
     * @param string $email
     * @param string $code
     * @return mixed
     */
    public function findByCode(string $email, string $code){

       return $this->entity->where('email',$email)->where('verification_code',$code)
           ->where('is_verified',false)
           ->first();
    }
}
