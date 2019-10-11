<?php

namespace App\Jobs;

use App\Models\Channel;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;
use Storage;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $channel, $fileId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Channel $channel, $fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = storage_path() . '/uploads/' . $this->fileId;
        $fileName = $this->fileId . '.png';

        Image::make($path)->encode('png')->fit(40, 40, function ($c) {
            $c->upsize();
        })->save();

        if(Storage::disk('s3images')->put('profile/' . $fileName, fopen($path, 'r+'))) {
            File::delete($path);
        }

        $this->channel->image_filename = $fileName;
        $this->channel->save();
    }
}
