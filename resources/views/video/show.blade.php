@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            @if($video->isPrivate() && Auth::check() && $video->ownedByUser(Auth::user()))
                <div class="alert alert-info" role="alert">
                  Your video is currently private only you can see it
                </div>
            @endif

            @if($video->isProcessed() && $video->canBeAccessed(Auth::user()))
                <video-player video-uid="{{$video->uid}}" video-url="{{$video->getStreamUrl()}}" thumbnail-url="{{$video->getThumbnail()}}"></video-player>
            @endif

            @if(!$video->isProcessed())
                <div class="video-placeholder">
                    <div class="video-placeholder__header">
                        This video is proccesing
                    </div>
                </div>
            @elseif(!$video->canBeAccessed(Auth::user()))
                <div class="video-placeholder">
                    <div class="video-placeholder__header">
                        This video is private
                    </div>
                </div>
            @endif
            
            <div class="card">

                <div class="card-body">
                    <h4>{{$video->title}}</h4>
                    <div class="float-right">
                        <div class="video__views">
                            {{ $video->viewCount() }} {{ Str::plural('view', $video->viewCount())}}
                        </div>

                        @if($video->votesAllowed())
                            <video-voting video-uid="{{ $video->uid }}"></video-voting>
                        @endif
                    </div>

                    <div class="media">
                        <div class="float-left">
                            <a href="/channel/{{ $video->channel->slug }}">
                                <img class="mr-3 img-fluid" src="{{ $video->channel->getImage() }}" alt="{{$video->channel->name}}" 
                                style="width: 45px;">
                            </a>
                        </div>
                      <div class="media-body">
                        <a href="/channel/{{ $video->channel->slug }}" class="h5">{{$video->channel->name}}</a>
                        <subscribe-button channel-slug="{{ $video->channel->slug }}"></subscribe-button>
                      </div>
                    </div>
                    
                </div>
            </div>
            
            @if($video->description)
                <div class="card mt-2">
                    <div class="card-body">
                        {!! nl2br(e($video->description)) !!}
                        
                    </div>
                </div>
            @endif

            <div class="card mt-2">
                <div class="card-body">
                    @if($video->commentsAllowed())
                       <video-comments video-uid="{{ $video->uid }}"></video-comments>
                    @else
                        <p>Comments are disabled for this video</p>
                    @endif    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
