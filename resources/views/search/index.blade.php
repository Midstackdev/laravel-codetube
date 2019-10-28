@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search for {{ Request::get('q') }}</div>

                <div class="card-body">
                    @if($channels->count())
                        <h4>Channels</h4>
                        <div class="card">
                            @foreach($channels as $channel)
                                <div class="card-body">
                                    <div class="media">
                                        <div class="float-left">
                                            <a href="/channel/{{ $channel->slug }}">
                                                <img class="mr-3 img-fluid" src="{{ $channel->getImage() }}" alt="{{$channel->name}}" 
                                                style="width: 45px;">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <a href="/channel/{{ $channel->slug }}" class="h5">{{$channel->name}}</a>
                                            Subscribe count
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($videos->count())
                        @foreach($videos as $video)
                            <div class="card">
                                <div class="card-body">
                                    @include('video.partials._video_result', compact('video'))
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No videos found</p>    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
