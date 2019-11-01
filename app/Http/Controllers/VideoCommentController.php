<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoCommentsResource;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoCommentController extends Controller
{
    public function index(Video $video)
    {
    	return VideoCommentsResource::collection($video->comments()->latest()->get());
    }
}
