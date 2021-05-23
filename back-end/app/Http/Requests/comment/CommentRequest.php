<?php

namespace App\Http\Requests\comment;

use App\Http\Requests\ApiBaseRequest;

class CommentRequest extends ApiBaseRequest
{

    public function rules()
    {
        return [
          'post_id' => ['required', 'integer'],
          'user_id' => ['required', 'integer'],
          'text' => ['required'],
        ];
    }
}
