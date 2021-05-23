<?php

namespace App\Http\Requests\post;

use App\Http\Requests\ApiBaseRequest;

class PostRequest extends ApiBaseRequest
{
    
    public function rules()
    {
        return [
          'user_id' => ['required', 'integer'],
          'title' => ['required'],
          'description' => ['required']
        ];
    }
}
