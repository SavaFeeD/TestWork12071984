<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'rate',
        'img'
    ];

    public $timestamps = false;

    public static function store($request) {
      $data = $request->all();

      if (isset($request->img) and $request->img != null and $request->img != '') {
        $img_name = File::createFile($request->img);
        $img_url = File::getFile($img_name);
        $data['img'] = $img_url;
      }

      $post = Post::create($data);
      $post->save();

      return response()->json([
        'status' => true,
        'body' => [
          'message' => 'Новый пост создан'
        ]
      ]);

    }
}
