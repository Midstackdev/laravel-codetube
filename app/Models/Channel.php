<?php

namespace App\Models;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
    	'name',
    	'slug',
    	'description',
    	'image_filename'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getImage()
    {
        if (!$this->image_filename) {
            return config('codetube.buckets.images') . '/profile/default.png';
        }
        
        return config('codetube.buckets.images') . '/profile/' . $this->image_filename;
    }
}