@extends('layouts.master')

@section('title')
    <title>Article Detail</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mt-4">Article Detail</h3>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Title</div>
                            <p>{{ $article['title'] }}</p>
                        </div>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Image URL</div>
                            <p>{{ $article['image_url'] }}</p>
                        </div>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Content</div>
                            <p>{{ $article['content'] }}</p>
                        </div>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Author</div>
                            <p>{{ $article['user']['name'] }}</p>
                        </div>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Category</div>
                            <p>{{ $article['articleCategory']['name'] }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
