<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    public static function getFile($filename) {
      return asset("storage/uploads/$filename");
    }

    public static function createFile($file) {
      $filename = $file->getClientOriginalName();
      $savefile = Storage::disk('public')->put('uploads', $file);
      $filename = explode('/', $savefile);
      $filename = $filename[count($filename)-1];
      return $filename;
    }
}
