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

            if(!$lastUserView) {
                $this->makeVideoViews($request, $video);
                return;
            }

    		if(!$this->withinBuffer($lastUserView)) {
                $this->makeVideoViews($request, $video);
    			return;
    		}
    	}

    	$lastIpView = $video->views()->latestByIp($request->ip())->first();

    	if($this->withinBuffer($lastIpView)) {
    		return;
    	}

    	$this->makeVideoViews($request, $video);

    	return response()->json(null, 200);
    }

    protected function makeVideoViews(Request $request, Video $video)
    {
        $video->views()->create([
            'user_id' => $request->user() ? $request->user()->id : null, // cannot be null
            'ip' => $request->ip()
        ]);
    }

    protected function withinBuffer($view)
    {
        // dd($view->createdAt());
    	return $view && $view->createdAt() < self::BUFFER;
    }
}
