<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    public function index()
    {
    	return view('video.upload');
    }
}
