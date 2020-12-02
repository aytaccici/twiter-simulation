<?php

namespace App\Http\Requests\Tweet;

use App\Http\Requests\Request;
use App\Models\Tweet;
use Illuminate\Support\Facades\Gate;


class PublishTweet extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'     => 'required|int',
            'content'     => 'nullable|min:3',
        ];
    }
}
