<?php

namespace App\Http\Requests\user;

use App\Http\Requests\ApiBaseRequest;

class LoginRequest extends ApiBaseRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => 'required'
        ];
    }
}
