@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Channel settings</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{route('edit.channel', $channel->slug)}}" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Name') }}</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $channel->name }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="slug" class="">{{ __('Unique url') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">{{config('app.url')}}/channel/</div>
                                </div>
                                <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') ? old('slug') : $channel->slug }}" required autocomplete="slug" autofocus>
                                @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="description" class="">{{ __('Description') }}</label>

                            <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') ? old('description') : $channel->description }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="image" class="">{{ __('Channel image') }}</label>

                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">

                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        @csrf
                        @method('put')
                        <button class="btn btn-outline-dark">Update</button>
                    </form>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
