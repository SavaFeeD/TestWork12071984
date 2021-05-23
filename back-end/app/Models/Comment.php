<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'user_id',
        'text'
    ];

    public static function store($request) {
      $data = $request->all();

      $post = Post::create($data);
      $post->save();

      return response()->json([
        'status' => true,
        'body' => [
          'message' => 'Новый комментарий создан'
        ]
      ]);

    }
}
