<?php

namespace App\Http\Requests\user;

use App\Http\Requests\ApiBaseRequest;

class RegisterRequest extends ApiBaseRequest
{

    public function rules()
    {
        return [
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required', 'min:3'],
            'password' => ['required', 'min:6']
        ];
    }
}
