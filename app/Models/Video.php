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
}
