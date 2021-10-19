@extends('layouts.master')

@section('title')
    <title>Article Category Detail</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mt-4">Article Category Detail</h3>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Name</div>
                                <p>{{ $category['name'] }}</p>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Image URL</div>
                                <p>{{ $category['image_url'] }}</p>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Articles</div>
                                @foreach ($category['articles'] as $article)
                                    <p>{{ $article['title'] }}</p>
                                @endforeach
                            </div>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
@endsection
