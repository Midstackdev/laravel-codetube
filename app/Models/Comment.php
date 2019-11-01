<?php

namespace App\Models;

use App\Traits\HasReplies;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use SoftDeletes, HasReplies;

    protected $fillable = [
    	'body',
    	'user_id',
    	'reply_id'
    ];

    public function commentable()
    {
    	return $this->morphTo();
    }

    public function replies()
    {
    	return $this->hasMany(Comment::class, 'reply_id', 'id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
