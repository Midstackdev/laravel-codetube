<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoViewController extends Controller
{
	const BUFFER = 30;

    public function create(Request $request, Video $video)
    {
    	if (!$video->canBeAccessed($request->user)) {
    		return;
    	}

    	if($request->user()) {
    		$lastUserView = $video->views()->latestByUser($request->user())->first();

    		if($this->withinBuffer($lastUserView)) {
    			return;
    		}
    	}

    	$lastIpView = $video->views()->latestByIp($request->ip());

    	if($this->withinBuffer($lastIpView)) {
    		return;
    	}

    	$video->views()->create([
    		'user_id' => $request->user() ? $request->user()->id : null, // cannot be null
    		'ip' => $request->ip()
    	]);

    	return response()->json(null, 200);
    }

    protected function withinBuffer($view)
    {
    	return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;
    }
}
