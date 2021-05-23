<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;

class CommentController extends Controller
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
    return response()->json(Comment::all());
  }

  public function show(Comment $id) {
    return $id;
  }

  public function store(CommentRequest $request) {
    return Comment::store($request);
  }

  public function delete(Request $request, $id) {
    return self::deleteItem(Comment::class, $request, $id);
  }

  public function update(Request $request, $id) {
    return self::updateItem(Comment::class, $request, $id);
  }
}
