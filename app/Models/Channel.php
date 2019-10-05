<?php

namespace App\Models;

use App\Models\User;
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
}
