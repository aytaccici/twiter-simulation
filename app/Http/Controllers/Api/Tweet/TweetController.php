<?php

namespace App\Http\Controllers\Api\Tweet;

use App\Contracts\TweetContract;
use App\Http\Controllers\BaseApiController;
use App\Http\Resources\User\TweetResource;
use App\Services\Tweet\TweetService;
use Illuminate\Http\Request;


class TweetController extends BaseApiController
{
    protected $repository;

    public function __construct(TweetContract $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = TweetResource::collection(($this->repository->getAllTweetsOrderByLatest()));
        return $this->service->success($data);
    }



    /**
     * @param Request $request
     * @param TweetService $tweetService
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(Request $request,  TweetService $tweetService){

        $tweetService->moveTweets();

        return $this->service->success();
    }





}
