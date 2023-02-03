<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
  public function getFile($path) {
    $content = file_get_contents($path);
    $content_decoded = json_decode($content);

    return $content_decoded;
  }
}
