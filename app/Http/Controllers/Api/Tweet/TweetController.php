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
     * @OA\GET(
     *      path="/api/v1/tweets",
     *      operationId="tweets",
     *      tags={"Tweeets"},
     *      summary="get all tweets in system",
     *      description="You can get all tweets using this endpoint",
     *        @OA\Response(
     *         response="200",
     *         description="success",
     *     ),
     *    @OA\Response(
     *          response=403,
     *          description="Forbidden error ",
     *      ),
     *      security={{ "apiAuth": {} }}
     *     )
     */

    public function index(Request $request)
    {
        $data = TweetResource::collection(($this->repository->getAllTweetsOrderByLatest()));
        return $this->service->success($data);
    }



    /**
     * @OA\POST(
     *      path="/api/v1/tweets/fetch",
     *      operationId="fetch",
     *      tags={"Tweeets"},
     *      summary="Fetch tweets of logger user from Twitter",
     *      description="You can move tweets from Twitter to this system using this end point",
     *        @OA\Response(
     *         response="200",
     *         description="success",
     *     ),
     *    @OA\Response(
     *          response=403,
     *          description="Forbidden error ",
     *      ),
     *      security={{ "apiAuth": {} }}
     *     )
     */

    public function fetchMyTweets(Request $request, TweetService $tweetService)
    {
        $tweetService->moveTweets();
        return $this->service->success();
    }



    /**
     * @OA\GET(
     *      path="/api/v1/tweets/me",
     *      operationId="me",
     *      tags={"Tweeets"},
     *      summary="Show tweets of logged user",
     *      description="You can list all published tweets of logged user",
     *        @OA\Response(
     *         response="200",
     *         description="success",
     *     ),
     *    @OA\Response(
     *          response=403,
     *          description="Forbidden error ",
     *      ),
     *      security={{ "apiAuth": {} }}
     *     )
     */
    public function me(Request $request, TweetService $tweetService)
    {

        $data = TweetResource::collection(($tweetService->getUserTweets()));
        return $this->service->success($data);
    }




    /**
     * @OA\GET(
     *      path="/api/v1/tweets/{username}",
     *      operationId="me",
     *      tags={"Tweeets"},
     *      summary="Show published tweets of username",
     *      description="You can list all published tweets of user",
     *        @OA\Response(
     *         response="200",
     *         description="success",
     *     ),
     * @OA\Parameter(
     *    description="Twitter username of User",
     *    in="path",
     *    name="username",
     *    required=true,
     *    example="Pascale.Gulgowski20",
     *    @OA\Schema(
     *       type="string"
     *    )
     * ),
     *    @OA\Response(
     *          response=403,
     *          description="Forbidden error ",
     *      ),
     *      security={{ "apiAuth": {} }}
     *     )
     */
    public function getUserTweetsByName($userName)
    {

        $data = TweetResource::collection(($this->repository->findUserTweetsByUserName((string)$userName)));

        return $this->service->success($data);
    }


    /**
     * @OA\PUT(
     *      path="/api/v1/tweets/publish",
     *      operationId="publish",
     *      tags={"Tweeets"},
     *      summary="Publish a  tweet",
     *      description="You can pushlish or edit a tweet using this end point",
     *        @OA\Response(
     *         response="200",
     *         description="success",
     *     ),
     *
        *     @OA\RequestBody(
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="id", type="string", description = "id of tweet which will be edit" ),
     *               @OA\Property(property="content", type="string", description = "If you want to edit tweet, you should fill this field."),
     *            )
     *        )
     *    ),
     *    @OA\Response(
     *          response=403,
     *          description="Forbidden error ",
     *      ),
     *    @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      security={{ "apiAuth": {} }}
     *     )
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
