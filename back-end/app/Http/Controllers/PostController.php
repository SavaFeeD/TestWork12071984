<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
  public function show(Post $id) {
    return collect($id)->except('api_token', 'password');
  }
}
