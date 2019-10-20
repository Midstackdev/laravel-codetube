<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EncodingWebhookController extends Controller
{
    public function handle(Request $request)
    {
    	$event = Str::camel($request->event);

    	if (method_exists($this, $event)) {
    		$this->{$event}($request);
    	}
    }

    protected function videoEncoded(Request $request)
    {
    	$video = $this->getVideoByFilename($request->original_filename);

    	$video->processed = 1;
    	$video->video_id = $request->encoding_ids[0];
    	$video->save();
    }

    protected function encodingProgress(Request $request)
    {
    	$video = $this->getVideoByFilename($request->original_filename);

    	$video->processing_percentage = $request->progress;
    	$video->save();

    }

    protected function getVideoByFilename($filename)
    {
    	return Video::where('video_filename', $filename)->firstOrFail();
    }
}
