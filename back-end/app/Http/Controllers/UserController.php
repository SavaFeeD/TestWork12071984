<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\user\LoginRequest;
use App\Http\Requests\user\RegisterRequest;
use App\Http\Requests\user\UserIdRequest;


class UserController extends Controller
{
    public function index(UserIdRequest$request) {
      $user_id = $request->user_id;
      $user = User::where('api_token', $request->bearerToken())->first();
      if ($user->id."" != $request->user_id and $user->role != 'admin')
        return response()->json([
          'status' => false,
          'body' => [
            'message' => 'Неправильный токен'
          ]
        ]);
      return response()->json(User::all());
    }

    public function login(LoginRequest $request) {
      return User::login($request);
    }

    public function store(RegisterRequest $request) {
      return User::store($request);
    }

    public function logout(UserIdRequest $request) {
      return User::logout($request);
    }

    public function delete(Request $request, $id) {
      return self::deleteItem(User::class, $request, $id, 'Пользователь удален');
    }

    public function update_user( $request, $id) {
      return self::updateItem(User::class, $request, $id, 'Данные пользователя обновлены');
    }

    public function show(User $id) {
      return collect($id)->except('api_token', 'password');
    }


}
