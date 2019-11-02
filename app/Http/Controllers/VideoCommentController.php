<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVideoCommentRequest;
use App\Http\Resources\VideoCommentsResource;
use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoCommentController extends Controller
{
    public function index(Video $video)
    {
    	return VideoCommentsResource::collection($video->comments()->latest()->get());
    }

    public function create(CreateVideoCommentRequest $request, Video $video)
    {
    	$this->authorize('comment', $video);

    	$comment = $video->comments()->create([
    		'body' => $request->body,
    		'reply_id' => $request->get('reply_id', null),
    		'user_id' => $request->user()->id
    	]);

    	return new VideoCommentsResource($comment);
    }

    public function delete(Video $video, Comment $comment)
    {
    	$this->authorize('delete', $comment);

    	$comment->delete();

    	return response()->json(null, 200);
    }
}
