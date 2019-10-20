@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit {{$video->title}}</div>

                    <div class="card-body">
                        <form action="{{route('update.video', $video->uid)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ? old('title') : $video->title }}">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') ? old('description') : $video->description }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="visibility">Visitility</label>
                                <select name="visibility" id="visibility" class="form-control">
                                    @foreach(['public', 'unlisted', 'private'] as $visibility)
                                        <option value="{{$visibility}}" {{$video->visibility == $visibility ? ' selected' : ''}}>
                                            {{ucfirst($visibility)}}
                                        </option>
                                    @endforeach
                                </select>

                                @error('visibility')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="allow_votes">
                                    <input type="checkbox" name="allow_votes" id="allow_votes" {{$video->votesAllowed() ? ' checked="checked"' : ''}}>
                                    Allow votes
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="allow_comments">
                                    <input type="checkbox" name="allow_comments" id="allow_comments" {{$video->commentsAllowed() ? ' checked="checked"' : ''}}>
                                    Allow comments
                                </label>
                            </div>

                            <button class="btn btn-outline-dark">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
