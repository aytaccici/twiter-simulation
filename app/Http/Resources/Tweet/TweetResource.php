<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'twitId'       => $this->id,
            'userName'     => $this->user->twitter,
            'likeCount'    => $this->liked_count,
            'reTweetCount' => $this->retweet_count,
            'content'      => $this->content,
            'createdAt'    => $this->created_at,
        ];
    }
}
