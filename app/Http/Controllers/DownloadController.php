<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
  public function getDownload($path) {
    return response()->download($path);
  }
}
