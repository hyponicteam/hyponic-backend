@extends('layouts.master')

@section('title')
    <title>Video Detail</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mt-4">Video Detail</h3>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Title</div>
                            <p>{{ $video['title'] }}</p>
                        </div>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Video URL</div>
                            <p>{{ $video['video_url'] }}</p>
                        </div>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Author</div>
                            <p>{{ $video['user']['name'] }}</p>
                        </div>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Category</div>
                            <p>{{ $video['videoCategory']['name'] }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
