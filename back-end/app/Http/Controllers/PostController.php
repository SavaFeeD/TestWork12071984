<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\post\PostRequest;

class PostController extends Controller
{
  public function index(Request $request) {
    $user = User::where('api_token', $request->bearerToken())->first();
    if ($user->role != 'admin')
      return response()->json([
        'status' => false,
        'body' => [
          'message' => 'Вы не админ'
        ]
      ]);
    return response()->json(Post::all());
  }

  public function show(Post $id) {
    return $id;
  }

  public function store(PostRequest $request) {
    return Post::store($request);
  }

  public function delete(Request $request, $id) {
    return self::deleteItem(Post::class, $request, $id);
  }

  public function update(Request $request, $id) {
    return self::updateItem(Post::class, $request, $id);
  }
}
