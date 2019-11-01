<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasReplies
{
	public function scopeCommentReplies(Builder $builder)
	{
		$builder->whereNotNull('reply_id');
	}
}