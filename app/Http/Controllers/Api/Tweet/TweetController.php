<?php

namespace App\Http\Controllers\Api\Tweet;

use App\Contracts\TweetContract;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Tweet\PublishTweet;
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
    public function fetchMyTweets(Request $request, TweetService $tweetService)
    {

        $tweetService->moveTweets();
        return $this->service->success();
    }


    /**
     * @param Request $request
     * @param TweetService $tweetService
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request, TweetService $tweetService)
    {

        $data = TweetResource::collection(($tweetService->getUserTweets()));
        return $this->service->success($data);
    }


    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserTweetsById($userId)
    {

        $data = TweetResource::collection(($this->repository->findUserTweets((int)$userId)));
        return $this->service->success($data);
    }

    /**
     * @param $userName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserTweetsByName($userName)
    {

        $data = TweetResource::collection(($this->repository->findUserTweetsByUserName((string)$userName)));

        return $this->service->success($data);
    }

    /**
     * @param PublishTweet $request
     * @param TweetService $tweetService
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(PublishTweet $request, TweetService $tweetService)
    {
        try {
            $tweet = $tweetService->publishTweet($request);
        } catch (\Exception $exception) {
            throw new $exception;
        }

        return $this->service->success(new TweetResource($tweet));
    }


}
