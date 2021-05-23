<?php

namespace App\Http\Requests\user;

use App\Http\Requests\ApiBaseRequest;

class UserIdRequest extends ApiBaseRequest
{

    public function rules()
    {
        return [
            'user_id' => ['required', 'integer']
        ];
    }
}
