<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function deleteItem($MODEL, $request, $id, $message = 'Удален', $error = 'Не существует') {
      $user = User::where('api_token', $request->bearerToken())->first();

      if ($user->role != 'admin') {
          return response()->json([
            'status' => false,
            'body' => [
              'message' => 'Токен не приндлежит админу'
            ]
          ]);
      }

      $item = $MODEL::find($id);
      if (!$item) {
        return response()->json([
          'status' => false,
          'body' => [
            'message' => $error
          ]
        ]);
      }

      $item->delete();

      return response()->json([
          'status' => true,
          'body' => [
              'message' => $message
          ]
      ], 200);
    }

    public static function update($MODEL, $request, $id, $message = 'Данные обновились') {
      $user = User::where('api_token', $request->bearerToken())->first();

      if ($user->role != 'admin') {
          return response()->json([
            'status' => false,
            'body' => [
              'message' => 'Токен не приндлежит админу'
            ]
          ]);
      }

      $MODEL::whereId($id)->update($request->all());

      return response()->json([
          'status' => true,
          'body' => [
              'message' => $message
          ]
      ], 200);
    }

}
