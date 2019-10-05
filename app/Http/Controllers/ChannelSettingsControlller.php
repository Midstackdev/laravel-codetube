<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelUpdateRequest;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelSettingsControlller extends Controller
{
    public function edit(Channel $channel)
    {
    	$this->authorize('edit', $channel);
    	return view('channel.settings.edit', [
    				'channel' => $channel
    			]);
    }

    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
    	$this->authorize('update', $channel);
    	
    	$channel->update([
    		'name' => $request->name,
    		'slug' => $request->slug,
    		'description' => $request->description,
    	]);

    	return redirect()->to(route('edit.channel', $channel->slug));
    }
}
