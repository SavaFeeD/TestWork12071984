<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function deleteItem($MODEL, $request, $id, $message = 'Удален', $error = 'Не существует') {
      $user = User::where('api_token', $request->bearerToken())->first();

      if ($user->role != 'admin') {
          return response()->json([
            'status' => false,
            'body' => [
              'message' => 'Вы не админ'
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

    public static function updateItem($MODEL, $request, $id, $message = 'Данные обновились') {
      $user = User::where('api_token', $request->bearerToken())->first();

      if ($user->role != 'admin') {
          return response()->json([
            'status' => false,
            'body' => [
              'message' => 'Вы не админ'
            ]
          ]);
      }

      $data = $request->all();
      if (isset($request->img) and $request->img != null and $request->img != '') {
        $img_name = File::createFile($request->img);
        $img_url = File::getFile($img_name);
        $data['img'] = $img_url;
      }

      $MODEL::whereId($id)->update($data);

      return response()->json([
          'status' => true,
          'body' => [
              'message' => $message
          ]
      ], 200);
    }

}
