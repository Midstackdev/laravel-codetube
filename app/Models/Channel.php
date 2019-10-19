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
}
