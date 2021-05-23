<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\File;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'api_token'
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function generateToken() {
        $this->api_token = Str::random(70);
        $this->save();
        return $this->api_token;
    }

    public static function login($request) {
        $message = '';

        $user = User::where('email', $request->email)->first();

        if (!$user) {
          $message = 'Пользователь с такой почтой не найден';
        } elseif (!Hash::check($request->password, $user->password)) {
          $message = 'Не правильный пароль';
        }

        if ($message != '') {
          return response()->json([
              'status' => false,
              'body' => [
                  'message' => $message
              ]
          ]);
        }

        $token = $user->generateToken();

        unset($user->password);
        unset($user->api_token);

        return response()->json([
            'status' => true,
            'body' => [
                'message' => 'Авторизация прошла успешно',
                'token' => $token,
                'user' => $user
            ]
        ]);
    }

    public static function store($request) {
      $user = User::create($request->all());
      $user->save();

      return response()->json([
        'status' => true,
        'body' => [
          'message' => 'Новый пользователь создан'
        ]
      ]);
    }

    public static function logout($request) {
      $user_id = $request->user_id;
      $user = User::where('api_token', $request->bearerToken())->first();
      if ($user->id."" != $request->user_id and $user->role != 'admin')
        return response()->json([
          'status' => false,
          'body' => [
            'message' => 'Неправильный токен'
          ]
        ]);

        $user->api_token = null;
        $user->save();

        return response()->json([
            'status' => true,
            'body' => [
                'message' => 'Вы успешно вышли'
            ]
        ], 200);
    }

}
