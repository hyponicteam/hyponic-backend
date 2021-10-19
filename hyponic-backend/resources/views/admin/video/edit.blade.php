@extends('layouts.master')

@section('title')
    <title>Edit Video</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Edit Video</h1>
                <form action="/videos/{{ $video['id'] }}" method="post">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $video['title'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Video URL</label>
                        <input type="text" class="form-control" id="video_url" name="video_url" value="{{ $video['video_url'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category ID</label><br />
                        <input type="text" class="form-control" id="category" name="video_category_id" value="{{ $video['video_category_id'] }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection