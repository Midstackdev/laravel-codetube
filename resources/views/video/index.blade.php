@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Videos</div>

                <div class="card-body">
                    @if ($videos->count())
                        @foreach($videos as $video)

                            <div class="card">
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <a href="/videos/{{$video->uid}}">
                                            <img src="{{ $video->getThumbnail() }}" alt="{{ $video->title }}" class="img-thumbnail img-fluid">
                                        </a>
                                    </div>
                                    <div class="col-sm-9">
                                        <a href="/videos/{{$video->uid}}">{{$video->title}}</a>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                @if(!$video->isProcessed())
                                                    Processing ({{ $video->processing_percentage ? $video->processing_percentage . '%' : 'Starting up'}})
                                                @else
                                                    <span>{{ $video->created_at->diffForHumans() }}</span>
                                                @endif
                                                <form action="{{route('delete.video', $video->uid)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('user.video.edit', $video->uid) }}" class="btn btn-outline-info btn-sm">     Edit
                                                    </a>
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                            <div class="col-sm-6">
                                                {{ ucfirst($video->visibility) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>

                        @endforeach
                        
                        {{$videos->links()}}
                    @else
                        <p>You have no videos.</p>
                        
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
