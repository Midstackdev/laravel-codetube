<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelSettingsController extends Controller
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

        if($request->file('image')) {
            $request->file('image')->move(storage_path() . '/uploads', $fileId = uniqid(true));
            
            $this->dispatch(new UploadImage($channel, $fileId));
        }

    	return redirect()->to(route('edit.channel', $channel->slug));
    }
}
