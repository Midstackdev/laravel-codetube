@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                	<div class="media">
                		<img class="mr-3" src="{{ $channel->getImage() }}" alt="{{ $channel->slug }} image" style="height: 64px; width: 64px;">
                		<div class="media-body">
                			<h5 class="mt-0">{{ $channel->name }}</h5>

                			<ul class="list-inline">
								<li class="list-inline-item">
									<subscribe-button channel-slug="{{ $channel->slug }}"></subscribe-button>
								</li>
								<li class="list-inline-item">
									{{ $channel->totalVideoViews() }} video {{ Str::plural('view', $channel->totalVideoViews()) }}
								</li>
                			</ul>

                			@if($channel->description)
								<hr>
								<p>{{ $channel->description }}</p>
                			@endif

                		</div>
                	</div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Videos From your {{$channel->name}} Channels</div>

                <div class="card-body">
                    @if($videos->count())
                        @foreach($videos as $video)
                            <div class="card mb-2">
                                <div class="card-body">
                                    @include('video.partials._video_result', compact('video'))
                                </div>
                            </div>
                        @endforeach

                        {{ $videos->links() }}
                    @else
						<p>{{ $channel->name }} has no videos</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
