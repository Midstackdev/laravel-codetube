<?php

namespace App\Models;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'title',
		'description',
		'uid',
		'video_id',
		'video_filename',
		'processed',
		'visibility',
		'allow_votes',
		'allow_comments',
		'processing_percentage'
	];

    public function channel()
    {
    	return $this->belongsTo(Channel::class);
    }

    public function getRouteKeyName()
    {
    	return 'uid';
    }

    public function isProcessed()
    {
    	return $this->processed;
    }

    public function getThumbnail()
    {
    	if (!$this->isProcessed()) {
    		return config('codetube.buckets.videos') . '/default-thumbnail.png';
    	}
    	
    	return config('codetube.buckets.videos') . '/' .$this->video_id. '_1.jpg';
    }

    public function votesAllowed()
    {
    	return (bool) $this->allow_votes;
    }

    public function commentsAllowed()
    {
    	return (bool) $this->allow_comments;
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function ownedByUser(User $user)
    {
        return $this->channel->user_id == $user->id;
    }

    public function canBeAccessed($user = null)
    {
        if (!$user && $this->isPrivate()){
            return false;
        }

        if($user && $this->isPrivate() && ($user->id !== $this->channel->user_id)) {
            return false;
        }

        return true;
    }

    public function getStreamUrl()
    {
        return config('codetube.buckets.videos') . '/' . $this->video_id . '.mp4';
    }

    public function views()
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount()
    {
        return $this->views->count();
    }
}
