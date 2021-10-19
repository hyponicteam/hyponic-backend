@extends('layouts.master')

@section('title')
    <title>Create New Video</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Create New Video</h1>
                <form action="/videos" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Video URL</label>
                        <input type="text" class="form-control" id="video_url" name="video_url">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category ID</label><br />
                        <input type="text" class="form-control" id="category" name="video_category_id">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
