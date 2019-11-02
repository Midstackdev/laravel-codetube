@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Videos From your Subscribed Channels</div>

                <div class="card-body">
                    @if($subscriptionVideos->count())
                        @foreach($subscriptionVideos as $video)
                            <div class="card mb-2">
                                <div class="card-body">
                                    @include('video.partials._video_result', compact('video'))
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
