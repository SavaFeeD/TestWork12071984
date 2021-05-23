<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public static function store($request) {
      if (isset($request->img) and $request->img != null and $request->img != '') {
        $img_name = File::createFile($request->img);
        $img_url = File::getFile($img_name);
        $request->img = $img_url;
      }

    }
}
