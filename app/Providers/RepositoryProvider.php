<?php

namespace App\Providers;

use App\Contracts\TweetContract;
use App\Contracts\UserContract;
use App\Repositories\TweetRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     * Laravel contractlarımızı, Repositer ile bind ettik. Böylelikle örneğin  UserContract'ı kullandığımızda
     * aslında UserRepository örneğine erişebileceğiz
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserContract::class, UserRepository::class);
        $this->app->bind(TweetContract::class, TweetRepository::class);
    }
}
