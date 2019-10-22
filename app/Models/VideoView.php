<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    protected $fillable = [
    	'user_id', 'ip'
    ]; 

    public function scopeByUser(Builder $builder, User $user)
    {
    	return $builder->where('user_id', $user->id);
    }

    public function scopelatestByUser(Builder $builder, User $user)
    {
    	return $builder->byUser($user)->orderBy('created_at', 'desc')->take(1);
    }

    public function scopelatestByIp(Builder $builder, $ip)
    {
    	return $builder->where('ip',$ip)->orderBy('created_at', 'desc')->take(1);
    }
}
